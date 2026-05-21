<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'fecha',
        'hora',
        'estado',
        'observaciones',
        'id_usuario',
        'id_peluquero',
        'id_servicio',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function peluquero()
    {
        return $this->belongsTo(Peluquero::class, 'id_peluquero', 'id_peluquero');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'CONFIRMADA');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'CANCELADA');
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha', '>=', today())
                     ->where('estado', '!=', 'CANCELADA')
                     ->orderBy('fecha')
                     ->orderBy('hora');
    }

    public function scopePasadas($query)
    {
        return $query->where('fecha', '<', today())
                     ->orderBy('fecha', 'desc')
                     ->orderBy('hora', 'desc');
    }
}