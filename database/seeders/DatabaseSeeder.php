<?php

namespace Database\Seeders;

use App\Models\NivelReparacion;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Sembrar los 5 niveles de reparación
        $niveles = [
            [
                'nivel'       => 1,
                'nombre'      => 'Básico',
                'descripcion' => 'Mantenimiento preventivo, limpieza, reinicio de software o configuración simple.',
                'horas_sla'   => 2,
            ],
            [
                'nivel'       => 2,
                'nombre'      => 'Menor',
                'descripcion' => 'Cambio de periféricos (baterías, pantallas, teclados) sin soldadura.',
                'horas_sla'   => 5,
            ],
            [
                'nivel'       => 3,
                'nombre'      => 'Intermedio',
                'descripcion' => 'Reparación de puertos de carga, limpieza de humedad leve o soldadura básica.',
                'horas_sla'   => 24,
            ],
            [
                'nivel'       => 4,
                'nombre'      => 'Avanzado',
                'descripcion' => 'Microsoldadura, reballing básico o fallas de encendido complejas.',
                'horas_sla'   => 72,
            ],
            [
                'nivel'       => 5,
                'nombre'      => 'Crítico',
                'descripcion' => 'Recuperación de datos, daños severos por corto circuito o piezas de importación.',
                'horas_sla'   => 120,
            ],
        ];

        foreach ($niveles as $nivel) {
            NivelReparacion::create($nivel);
        }

        // 2. Crear taller demo
        $taller = Taller::create([
            'nombre'             => 'Taller Demo FixFlow',
            'telefono'           => '5500000000',
            'direccion'          => 'Calle Ejemplo 123, Ciudad',
            'suscripcion_activa' => true,
        ]);

        // 3. Crear usuario admin del taller
        User::create([
            'taller_id' => $taller->id,
            'name'      => 'Admin Demo',
            'email'     => 'admin@fixflow.test',
            'password'  => Hash::make('password'),
            'rol'       => 'admin',
        ]);

        // 4. Crear usuario técnico del taller
        User::create([
            'taller_id' => $taller->id,
            'name'      => 'Técnico Demo',
            'email'     => 'tecnico@fixflow.test',
            'password'  => Hash::make('password'),
            'rol'       => 'tecnico',
        ]);
    }
}
