<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Peluquero;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CitaAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Cita::with(['usuario', 'peluquero', 'servicio']);

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('peluquero')) {
            $query->where('id_peluquero', $request->peluquero);
        }
        if ($request->filled('buscar')) {
            $query->whereHas('usuario', fn ($q) =>
                $q->where('nombre', 'like', '%'.$request->buscar.'%')
                  ->orWhere('apellidos', 'like', '%'.$request->buscar.'%')
                  ->orWhere('email', 'like', '%'.$request->buscar.'%')
            );
        }

        $citas      = $query->orderBy('fecha', 'asc')->orderBy('hora', 'asc')->paginate(20)->withQueryString();
        $peluqueros = Peluquero::orderBy('nombre')->get();

        return view('admin.citas.index', compact('citas', 'peluqueros'));
    }

    public function show(int $id)
    {
        $cita       = Cita::with(['usuario', 'peluquero', 'servicio'])->findOrFail($id);
        $peluqueros = Peluquero::activos()->orderBy('nombre')->get();
        $servicios  = Servicio::activos()->orderBy('nombre')->get();

        return view('admin.citas.show', compact('cita', 'peluqueros', 'servicios'));
    }

    public function confirmar(int $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->update(['estado' => 'CONFIRMADA']);

        return redirect()->route('admin.citas.show', $id)
            ->with('success', 'Cita confirmada correctamente.')
            ->with('descargar_ics', $id);
    }

    public function actualizar(Request $request, int $id)
    {
        $cita = Cita::findOrFail($id);

        $data = $request->validate([
            'fecha'         => 'required|date',
            'hora'          => 'required|date_format:H:i',
            'id_peluquero'  => 'required|exists:peluqueros,id_peluquero',
            'id_servicio'   => 'required|exists:servicios,id_servicio',
            'estado'        => 'required|in:CONFIRMADA,CANCELADA',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $cita->update($data);

        return redirect()->route('admin.citas.show', $id)
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $cita = Cita::findOrFail($id);

        try {
            $cita->delete();
            return redirect()->route('admin.citas.index')
                ->with('success', 'Cita eliminada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.citas.index')
                ->with('error', 'No se puede eliminar la cita.');
        }
    }

    public function descargarIcs(int $id)
    {
        $cita = Cita::with(['usuario', 'peluquero', 'servicio'])->findOrFail($id);

        return response($this->generarIcs($cita), 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="cita-'.$id.'.ics"',
        ]);
    }

    private function generarIcs(Cita $cita): string
    {
        $inicio  = Carbon::parse($cita->fecha->toDateString().' '.$cita->hora);
        $fin     = $inicio->copy()->addMinutes($cita->servicio->duracion);
        $dtStamp = now()->format('Ymd\THis\Z');
        $uid     = 'admin-cita-'.$cita->id_cita.'@st-barber';
        $summary = 'Cita: '.$cita->servicio->nombre.' — '.$cita->usuario->nombre.' '.$cita->usuario->apellidos;
        $desc    = 'Peluquero: '.$cita->peluquero->nombre.' '.$cita->peluquero->apellidos;

        return "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ST BARBER//ES\r\n"
            ."BEGIN:VEVENT\r\n"
            ."UID:{$uid}\r\n"
            ."DTSTAMP:{$dtStamp}\r\n"
            ."DTSTART:".$inicio->format('Ymd\THis')."\r\n"
            ."DTEND:".$fin->format('Ymd\THis')."\r\n"
            ."SUMMARY:{$summary}\r\n"
            ."DESCRIPTION:{$desc}\r\n"
            ."LOCATION:ST BARBER\r\n"
            ."END:VEVENT\r\n"
            ."END:VCALENDAR\r\n";
    }
}
