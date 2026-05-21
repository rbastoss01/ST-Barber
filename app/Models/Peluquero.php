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

    protected function casts(): array
    {
        return [
            'activo'  => 'boolean',
            'ausente' => 'boolean',
        ];
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_peluquero', 'id_peluquero');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeNoAusentes($query)
    {
        return $query->where('ausente', false);
    }
}