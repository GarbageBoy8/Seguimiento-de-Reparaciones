<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $codigosUsados = [];

        DB::table('talleres')
            ->select(['id', 'nombre', 'codigo_publico'])
            ->orderBy('id')
            ->get()
            ->each(function ($taller) use (&$codigosUsados) {
                $codigo = $this->codigoTaller($taller, $codigosUsados);

                if ($taller->codigo_publico !== $codigo) {
                    DB::table('talleres')
                        ->where('id', $taller->id)
                        ->update(['codigo_publico' => $codigo]);
                }

                $secuenciasPorAnio = [];

                DB::table('reparaciones')
                    ->select(['id', 'created_at'])
                    ->where('taller_id', $taller->id)
                    ->orderBy('created_at')
                    ->orderBy('id')
                    ->get()
                    ->each(function ($reparacion) use ($codigo, &$secuenciasPorAnio) {
                        $anio = $reparacion->created_at
                            ? date('Y', strtotime($reparacion->created_at))
                            : now()->year;

                        $secuenciasPorAnio[$anio] = ($secuenciasPorAnio[$anio] ?? 0) + 1;

                        DB::table('reparaciones')
                            ->where('id', $reparacion->id)
                            ->update([
                                'folio' => sprintf('FF-%s-%s-%04d', $codigo, $anio, $secuenciasPorAnio[$anio]),
                            ]);
                    });
            });

        if (! $this->indexExists('reparaciones', 'reparaciones_taller_id_index')) {
            Schema::table('reparaciones', function (Blueprint $table) {
                $table->index('taller_id', 'reparaciones_taller_id_index');
            });
        }

        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropUnique('reparaciones_taller_folio_unique');
            $table->unique('folio', 'reparaciones_folio_unique');
        });
    }

    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropUnique('reparaciones_folio_unique');
            $table->unique(['taller_id', 'folio'], 'reparaciones_taller_folio_unique');
        });

        if ($this->indexExists('reparaciones', 'reparaciones_taller_id_index')) {
            Schema::table('reparaciones', function (Blueprint $table) {
                $table->dropIndex('reparaciones_taller_id_index');
            });
        }
    }

    private function codigoTaller(object $taller, array &$codigosUsados): string
    {
        $base = $this->normalizarCodigo($taller->codigo_publico);

        if ($base === '') {
            $base = substr($this->normalizarCodigo($taller->nombre), 0, 4);
        }

        $base = $base !== '' ? $base : 'TALL';
        $codigo = $base;
        $contador = 2;

        while (in_array($codigo, $codigosUsados, true) || DB::table('talleres')->where('id', '!=', $taller->id)->where('codigo_publico', $codigo)->exists()) {
            $sufijo = (string) $contador;
            $codigo = substr($base, 0, 10 - strlen($sufijo)) . $sufijo;
            $contador++;
        }

        $codigosUsados[] = $codigo;

        return $codigo;
    }

    private function normalizarCodigo(?string $codigo): string
    {
        $codigo = Str::ascii($codigo ?? '');
        $codigo = preg_replace('/[^A-Za-z0-9]/', '', $codigo) ?? '';

        return substr(strtoupper($codigo), 0, 10);
    }

    private function indexExists(string $table, string $index): bool
    {
        return DB::table('information_schema.statistics')
            ->whereRaw('table_schema = DATABASE()')
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }
};
