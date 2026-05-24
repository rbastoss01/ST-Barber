<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Peluquero;
use App\Models\Servicio;
use App\Models\Usuario;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Usuario::where('tipo_usuario', 'CLIENTE')->count();
        $totalServicios = Servicio::where('activo', true)->count();
        $totalPeluqueros = Peluquero::where('activo', true)->count();
        $totalCitas = Cita::count();

        Carbon::setLocale('es');

        $confirmadasHoy = Cita::whereDate('fecha', today())->where('estado', 'CONFIRMADA')->count();
        $canceladasHoy = Cita::whereDate('fecha', today())->where('estado', 'CANCELADA')->count();

        $citasHoy = Cita::whereDate('fecha', today())
            ->with(['usuario', 'peluquero', 'servicio'])
            ->orderBy('hora')
            ->get();

        $proximasCitas = Cita::where('fecha', '>', today())
            ->where('estado', '!=', 'CANCELADA')
            ->with(['usuario', 'peluquero', 'servicio'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->take(8)
            ->get();

        $inicioSemana = now()->startOfWeek();
        $citasSemanaActual = [];
        for ($i = 0; $i < 6; $i++) {
            $dia = $inicioSemana->copy()->addDays($i);
            $citasSemanaActual[] = Cita::whereDate('fecha', $dia->toDateString())
                ->where('estado', '!=', 'CANCELADA')
                ->count();
        }

        $citasPorSemana = [];
        $etiquetasSemanas = [];
        for ($i = 5; $i >= 0; $i--) {
            $ini = now()->startOfWeek()->subWeeks($i);
            $fin = $ini->copy()->endOfWeek();
            $citasPorSemana[]   = Cita::whereBetween('fecha', [$ini->toDateString(), $fin->toDateString()])
                ->where('estado', '!=', 'CANCELADA')
                ->count();
            $etiquetasSemanas[] = $ini->format('d/m');
        }

        return view('admin.dashboard', compact(
            'totalClientes', 'totalServicios', 'totalPeluqueros', 'totalCitas',
            'confirmadasHoy', 'canceladasHoy',
            'citasHoy', 'proximasCitas',
            'citasSemanaActual', 'citasPorSemana', 'etiquetasSemanas'
        ));
    }
}
