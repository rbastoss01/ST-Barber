<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peluquero extends Model
{
    protected $table = 'peluqueros';
    protected $primaryKey = 'id_peluquero';

    protected $fillable = [
        'nombre',
        'apellidos',
        'especialidad',
        'activo',
        'ausente',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ausente' => 'boolean',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_peluquero', 'id_peluquero');
    }

}