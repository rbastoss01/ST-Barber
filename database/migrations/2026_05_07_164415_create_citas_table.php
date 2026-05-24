<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado', 20)->default('PENDIENTE');
            $table->text('observaciones')->nullable();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id')->onDelete('restrict');
            $table->foreignId('id_peluquero')->constrained('peluqueros', 'id_peluquero')->onDelete('restrict');
            $table->foreignId('id_servicio')->constrained('servicios', 'id_servicio')->onDelete('restrict');
            $table->unique(['id_peluquero', 'fecha', 'hora']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};