<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->unsignedTinyInteger('dia_semana')->unique()->comment('1=Lunes … 7=Domingo');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        DB::table('horarios')->insert([
            ['dia_semana' => 1, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 2, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 3, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 4, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 5, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 6, 'hora_inicio' => '09:00:00', 'hora_fin' => '14:00:00', 'activo' => true,  'created_at' => now(), 'updated_at' => now()],
            ['dia_semana' => 7, 'hora_inicio' => '09:00:00', 'hora_fin' => '14:00:00', 'activo' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
