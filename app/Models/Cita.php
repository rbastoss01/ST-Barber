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

    protected $casts = [
        'fecha' => 'date',
    ];

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

}