<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Peluquero;

class PublicoController extends Controller
{
    public function inicio()
    {
        $serviciosDestacados = Servicio::activos()
            ->orderBy('id_servicio')
            ->take(4)
            ->get();

        $peluqueros = Peluquero::activos()
            ->orderBy('nombre')
            ->get();

        return view('publico.inicio', compact('serviciosDestacados', 'peluqueros'));
    }

    public function servicios()
    {
        $servicios = Servicio::activos()
            ->orderBy('nombre')
            ->get();

        return view('publico.servicios', compact('servicios'));
    }

    public function informacion()
    {
        return view('publico.informacion');
    }
}
