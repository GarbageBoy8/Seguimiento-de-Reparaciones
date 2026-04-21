<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Corrige el índice único de 'folio' para ser compuesto por taller.
     * Un folio es único DENTRO de cada taller, no globalmente.
     * Esto permite que cada taller tenga su propio FF-2026-0001.
     */
    public function up(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            // Eliminar el índice único global sobre folio
            $table->dropUnique('reparaciones_folio_unique');

            // Agregar índice único compuesto: (taller_id, folio)
            $table->unique(['taller_id', 'folio'], 'reparaciones_taller_folio_unique');
        });
    }

    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropUnique('reparaciones_taller_folio_unique');
            $table->unique('folio', 'reparaciones_folio_unique');
        });
    }
};
