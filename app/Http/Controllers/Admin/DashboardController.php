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
        $totalClientes  = Usuario::clientes()->count();
        $totalServicios = Servicio::activos()->count();
        $totalPeluqueros = Peluquero::activos()->count();
        $totalCitas     = Cita::count();

        Carbon::setLocale('es');

        // Fecha del dia
        $confirmadasHoy = Cita::whereDate('fecha', today())->confirmadas()->count();
        $canceladasHoy  = Cita::whereDate('fecha', today())->canceladas()->count();

        // Tabla citas del día
        $citasHoy = Cita::whereDate('fecha', today())
            ->with(['usuario', 'peluquero', 'servicio'])
            ->orderBy('hora')
            ->get();

        // Próximas citas
        $proximasCitas = Cita::where('fecha', '>', today())
            ->where('estado', '!=', 'CANCELADA')
            ->with(['usuario', 'peluquero', 'servicio'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->take(8)
            ->get();

        // Gráfica de citas semanal
        $inicioSemana = now()->startOfWeek(Carbon::MONDAY);
        $citasSemanaActual = [];
        for ($i = 0; $i < 6; $i++) {
            $dia = $inicioSemana->copy()->addDays($i);
            $citasSemanaActual[] = Cita::whereDate('fecha', $dia->toDateString())
                ->where('estado', '!=', 'CANCELADA')
                ->count();
        }

        // Gráfica de citas ultimas 6 semanas
        $citasPorSemana   = [];
        $etiquetasSemanas = [];
        for ($i = 5; $i >= 0; $i--) {
            $ini = now()->startOfWeek(Carbon::MONDAY)->subWeeks($i);
            $fin = $ini->copy()->endOfWeek();
            $citasPorSemana[]   = Cita::whereBetween('fecha', [$ini->toDateString(), $fin->toDateString()])
                ->where('estado', '!=', 'CANCELADA')
                ->count();
            $etiquetasSemanas[] = $ini->translatedFormat('d M');
        }

        return view('admin.dashboard', compact(
            'totalClientes', 'totalServicios', 'totalPeluqueros', 'totalCitas',
            'confirmadasHoy', 'canceladasHoy',
            'citasHoy', 'proximasCitas',
            'citasSemanaActual', 'citasPorSemana', 'etiquetasSemanas'
        ));
    }
}
