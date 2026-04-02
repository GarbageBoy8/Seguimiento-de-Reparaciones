<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niveles_reparacion', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('nivel')->unsigned()->unique(); // 1 al 5
            $table->string('nombre');                           // Básico, Menor, etc.
            $table->text('descripcion');
            $table->integer('horas_sla');                      // 2, 5, 24, 72, 120
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveles_reparacion');
    }
};
