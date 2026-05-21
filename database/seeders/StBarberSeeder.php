<?php

namespace Database\Seeders;

use App\Models\Horario;
use App\Models\Peluquero;
use App\Models\Servicio;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StBarberSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Horario::truncate();
        Servicio::truncate();
        Peluquero::truncate();
        Usuario::where('email', 'like', '%@stbarber.test')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Admin
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@stbarber.test'],
            [
                'nombre'         => 'Admin',
                'apellidos'      => 'ST Barber',
                'password'       => Hash::make('admin'),
                'tipo_usuario'   => 'ADMINISTRADOR',
                'activo'         => true,
                'fecha_registro' => today(),
            ]
        );

        // Clientes
        $clientes = [
            ['nombre' => 'Carlos',    'apellidos' => 'Martínez López',  'email' => 'carlos@stbarber.test',   'telefono' => '612 345 678'],
            ['nombre' => 'Alejandro', 'apellidos' => 'Ruiz Fernández',  'email' => 'alejandro@stbarber.test', 'telefono' => '623 456 789'],
            ['nombre' => 'Miguel',    'apellidos' => 'Sánchez García',  'email' => 'miguel@stbarber.test',    'telefono' => '634 567 890'],
        ];

        foreach ($clientes as $datos) {
            Usuario::create([
                ...$datos,
                'password'       => Hash::make('cliente1234'),
                'tipo_usuario'   => 'CLIENTE',
                'activo'         => true,
                'fecha_registro' => today()->subDays(rand(10, 120)),
            ]);
        }

        // Peluqueros
        Peluquero::create(['nombre' => 'Diego',   'apellidos' => 'Vega Moreno',   'especialidad' => 'Barba y afeitado clásico',  'activo' => true]);
        Peluquero::create(['nombre' => 'Andrés',  'apellidos' => 'Torres Blanco', 'especialidad' => 'Corte moderno y degradado', 'activo' => true]);
        Peluquero::create(['nombre' => 'Roberto', 'apellidos' => 'Lara Castillo', 'especialidad' => 'Coloración y tratamientos',  'activo' => true]);

        // Servicios
        Servicio::create(['nombre' => 'Corte de pelo',    'descripcion' => 'Corte personalizado adaptado a tu estilo.',          'precio' => 15.00, 'duracion' => 30, 'activo' => true]);
        Servicio::create(['nombre' => 'Arreglo de barba', 'descripcion' => 'Perfilado y arreglo de barba con navaja caliente.',  'precio' => 10.00, 'duracion' => 20, 'activo' => true]);
        Servicio::create(['nombre' => 'Corte + Barba',    'descripcion' => 'Pack completo: corte y arreglo de barba.',           'precio' => 22.00, 'duracion' => 50, 'activo' => true]);
        Servicio::create(['nombre' => 'Afeitado clásico', 'descripcion' => 'Afeitado tradicional con toalla caliente y navaja.', 'precio' => 18.00, 'duracion' => 40, 'activo' => true]);

        // Horarios
        $horariosConfig = [
            1 => ['09:00', '20:00'],
            2 => ['09:00', '20:00'],
            3 => ['09:00', '20:00'],
            4 => ['09:00', '20:00'],
            5 => ['09:00', '20:00'],
            6 => ['10:00', '18:00'],
        ];

        foreach ($horariosConfig as $dia => $horas) {
            Horario::create([
                'dia_semana'  => $dia,
                'hora_inicio' => $horas[0],
                'hora_fin'    => $horas[1],
                'activo'      => true,
            ]);
        }

        Horario::create(['dia_semana' => 7, 'hora_inicio' => '09:00', 'hora_fin' => '14:00', 'activo' => false]);

        // Información
        $this->command->info('Admin:      admin@stbarber.test  /  admin');
        $this->command->info('Clientes:   *@stbarber.test      /  cliente1234');
        $this->command->info('Peluqueros: 3');
        $this->command->info('Servicios:  4');
        $this->command->info('Horarios:   Lun – Sáb activos, Dom cerrado');
    }
}