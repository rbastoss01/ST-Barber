<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'activo',
        'tipo_usuario',
        'telefono',
        'fecha_registro',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'activo' => 'boolean',
        'fecha_registro' => 'date',
    ];
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_usuario');
    }

    public function esAdmin()
    {
        return $this->tipo_usuario === 'ADMINISTRADOR';
    }

    public function esCliente()
    {
        return $this->tipo_usuario === 'CLIENTE';
    }
}