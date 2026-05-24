<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Peluquero;

class PublicController extends Controller
{
    public function inicio()
    {
        $serviciosDestacados = Servicio::where('activo', true)
            ->orderBy('id_servicio')
            ->take(4)
            ->get();

        $peluqueros = Peluquero::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('publico.inicio', compact('serviciosDestacados', 'peluqueros'));
    }

    public function servicios()
    {
        $servicios = Servicio::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('publico.servicios', compact('servicios'));
    }

    public function informacion()
    {
        return view('publico.informacion');
    }
}
