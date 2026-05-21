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

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'activo' => 'boolean',
            'fecha_registro' => 'date',
        ];
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_usuario');
    }

    public function scopeClientes($query)
    {
        return $query->where('tipo_usuario', 'CLIENTE');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
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