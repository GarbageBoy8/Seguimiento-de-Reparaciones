<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taller_id')->constrained('talleres')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('nivel_id')->constrained('niveles_reparacion')->restrictOnDelete();

            // Identificación única
            $table->string('folio')->unique();
            $table->string('token_seguimiento')->unique();

            // Datos del dispositivo
            $table->string('tipo_equipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie')->nullable();

            // Diagnóstico
            $table->text('problema_reportado');
            $table->text('diagnostico_tecnico')->nullable();
            $table->text('comentario_retardo')->nullable();

            // Estado
            $table->enum('estado', [
                'Recibido',
                'En Revisión',
                'Esperando Pieza',
                'Reparado',
                'Entregado',
                'Cancelado',
                'Retardo',
            ])->default('Recibido');

            // Costos
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->decimal('costo_final', 10, 2)->nullable();

            // Control de tiempos (SLA)
            $table->timestamp('hora_ingreso')->nullable();
            $table->timestamp('hora_limite')->nullable();
            $table->timestamp('hora_fin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};
