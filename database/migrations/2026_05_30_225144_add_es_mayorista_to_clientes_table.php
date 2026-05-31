<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            //Creamos el booleano si no se especifia, por defecto es cliente normal (0)
            $table->boolean('es_mayorista')->default(false)->after('direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('es_mayorista');
        });
    }
};
