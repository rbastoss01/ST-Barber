<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmacionCita;
use App\Mail\NuevaCitaAdmin;
use App\Models\Cita;
use App\Models\Peluquero;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitaController extends Controller
{
    private $horarios = [
        1 => ['inicio' => '09:00', 'fin' => '20:00'],
        2 => ['inicio' => '09:00', 'fin' => '20:00'],
        3 => ['inicio' => '09:00', 'fin' => '20:00'],
        4 => ['inicio' => '09:00', 'fin' => '20:00'],
        5 => ['inicio' => '09:00', 'fin' => '20:00'],
        6 => ['inicio' => '09:00', 'fin' => '14:00']
    ];

    public function index()
    {
        $proximas = auth()->user()->citas()
            ->where('fecha', '>=', today())
            ->where('estado', '!=', 'CANCELADA')
            ->orderBy('fecha')
            ->orderBy('hora')
            ->with(['servicio', 'peluquero'])
            ->get();

        $pasadas = auth()->user()->citas()
            ->where('fecha', '<', today())
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->with(['servicio', 'peluquero'])
            ->get();

        return view('cliente.mis-citas', compact('proximas', 'pasadas'));
    }

    public function formulario(?int $servicio = null)
    {
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $peluqueros = Peluquero::where('activo', true)->where('ausente', false)->orderBy('nombre')->get();

        $servicioPreseleccionado = $servicio
            ? Servicio::where('activo', true)->find($servicio)
            : null;

        $cita = null;

        return view('cliente.reservar', compact('servicios', 'peluqueros', 'servicioPreseleccionado', 'cita'));
    }

    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'id_peluquero' => ['required', 'exists:peluqueros,id_peluquero'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'date_format:H:i'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ], [
            'id_servicio.required' => 'Selecciona un servicio.',
            'id_peluquero.required' => 'Selecciona un peluquero.',
            'fecha.required' => 'Selecciona una fecha.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'hora.required' => 'Selecciona una hora.',
        ]);

        $servicio = Servicio::findOrFail($datos['id_servicio']);

        $slots = $this->generarSlots($datos['fecha'], (int) $datos['id_peluquero'], $servicio->duracion);
        $slotDisponible = collect($slots)->firstWhere('hora', $datos['hora']);

        if (! $slotDisponible || ! $slotDisponible['disponible']) {
            return back()->withInput()
                ->with('error', 'La hora seleccionada ya no está disponible. Por favor elige otra.');
        }

        $cita = Cita::create([
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'] . ':00',
            'estado' => 'CONFIRMADA',
            'observaciones' => $datos['observaciones'] ?? null,
            'id_usuario' => auth()->id(),
            'id_peluquero' => $datos['id_peluquero'],
            'id_servicio' => $datos['id_servicio'],
        ]);

        $cita->load('usuario', 'peluquero', 'servicio');

        // try {
        //     Mail::to($cita->usuario->email)->send(new ConfirmacionCita($cita));
        //     Mail::to(config('mail.from.address'))->send(new NuevaCitaAdmin($cita));
        // } catch (\Exception $e) {
        //     \Log::error('Error enviando correo: ' . $e->getMessage());
        // }

        return redirect()->route('citas.confirmacion', $cita->id_cita);
    }

    public function editar(int $id)
    {
        $cita = auth()->user()->citas()
            ->with(['servicio', 'peluquero'])
            ->findOrFail($id);

        if ($cita->fecha->lt(today()) || $cita->estado === 'CANCELADA') {
            return redirect()->route('citas.index')
                ->with('error', 'No puedes modificar esta cita.');
        }

        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $peluqueros = Peluquero::where('activo', true)->orderBy('nombre')->get();
        $servicioPreseleccionado = null;

        return view('cliente.reservar', compact('servicios', 'peluqueros', 'servicioPreseleccionado', 'cita'));
    }

    public function actualizar(Request $request, int $id)
    {
        $cita = auth()->user()->citas()->findOrFail($id);

        if ($cita->fecha->lt(today()) || $cita->estado === 'CANCELADA') {
            return redirect()->route('citas.index')
                ->with('error', 'No puedes modificar esta cita.');
        }

        $datos = $request->validate([
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'id_peluquero' => ['required', 'exists:peluqueros,id_peluquero'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'date_format:H:i'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ]);

        $servicio = Servicio::findOrFail($datos['id_servicio']);

        $cambiaSlot = $cita->id_peluquero != $datos['id_peluquero']
                   || $cita->fecha->format('Y-m-d') !== $datos['fecha']
                   || substr($cita->hora, 0, 5) !== $datos['hora'];

        if ($cambiaSlot) {
            $slots = $this->generarSlots(
                $datos['fecha'],
                (int) $datos['id_peluquero'],
                $servicio->duracion,
                $cita->id_cita
            );
            $slotDisponible = collect($slots)->firstWhere('hora', $datos['hora']);

            if (! $slotDisponible || ! $slotDisponible['disponible']) {
                return back()->withInput()
                    ->with('error', 'La hora seleccionada ya no está disponible.');
            }
        }

        $cita->update([
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'] . ':00',
            'estado' => 'CONFIRMADA',
            'observaciones' => $datos['observaciones'] ?? null,
            'id_peluquero' => $datos['id_peluquero'],
            'id_servicio' => $datos['id_servicio'],
        ]);

        return redirect()->route('citas.index')
            ->with('success', 'Cita modificada correctamente.');
    }

    public function cancelar(int $id)
    {
        $cita = auth()->user()->citas()->findOrFail($id);

        if ($cita->fecha->lt(today()) || $cita->estado === 'CANCELADA') {
            return redirect()->route('citas.index')
                ->with('error', 'No puedes cancelar esta cita.');
        }

        $cita->update(['estado' => 'CANCELADA']);

        return redirect()->route('citas.index')
            ->with('success', 'Cita cancelada correctamente.');
    }

    public function confirmacion(int $id)
    {
        \Carbon\Carbon::setLocale('es');

        $cita = auth()->user()->citas()
            ->with(['servicio', 'peluquero'])
            ->findOrFail($id);

        return view('cliente.confirmacion', compact('cita'));
    }

    public function descargarIcs(int $id)
    {
        $cita = auth()->user()->citas()
            ->with(['servicio', 'peluquero'])
            ->findOrFail($id);

        return response($this->generarIcs($cita), 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="cita-' . $cita->id_cita . '.ics"',
            'Cache-Control'       => 'no-store',
        ]);
    }

    public function comprobarDisponibilidad(Request $request)
    {
        $request->validate([
            'fecha' => ['required', 'date'],
            'id_peluquero' => ['required', 'exists:peluqueros,id_peluquero'],
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
        ]);

        $servicio = Servicio::findOrFail($request->id_servicio);
        $excluirCita = $request->integer('excluir_cita', 0) ?: null;

        $slots = $this->generarSlots(
            $request->fecha,
            (int) $request->id_peluquero,
            $servicio->duracion,
            $excluirCita
        );

        return response()->json(['slots' => $slots]);
    }

    private function generarSlots($fecha, $idPeluquero, $duracion, $excluirCita = null) {
        $diaISO = Carbon::parse($fecha)->dayOfWeekIso;

        if (! isset($this->horarios[$diaISO])) {
            return [];
        }

        $horario = $this->horarios[$diaISO];
        $inicio = Carbon::createFromFormat('H:i', $horario['inicio']);
        $fin = Carbon::createFromFormat('H:i', $horario['fin']);

        $slots = [];
        $cursor = $inicio->copy();
        while ($cursor->copy()->addMinutes($duracion)->lte($fin)) {
            $slots[] = $cursor->format('H:i');
            $cursor->addMinutes(30);
        }

        $citasExistentes = Cita::where('id_peluquero', $idPeluquero)
            ->where('fecha', $fecha)
            ->where('estado', '!=', 'CANCELADA')
            ->when($excluirCita, fn ($q) => $q->where('id_cita', '!=', $excluirCita))
            ->with('servicio')
            ->get();

        $ahora = now();
        $esHoy = Carbon::parse($fecha)->isToday();

        return array_map(function (string $horaSlot) use ($citasExistentes, $duracion, $esHoy, $ahora) {
            $slotInicio = Carbon::createFromFormat('H:i', $horaSlot);
            $slotFin = $slotInicio->copy()->addMinutes($duracion);

            if ($esHoy && $slotInicio->lte($ahora->copy()->addMinutes(30))) {
                return ['hora' => $horaSlot, 'disponible' => false];
            }

            foreach ($citasExistentes as $cita) {
                $citaInicio = Carbon::createFromFormat('H:i:s', $cita->hora);
                $citaFin = $citaInicio->copy()->addMinutes($cita->servicio->duracion ?? 30);

                if ($slotInicio->lt($citaFin) && $slotFin->gt($citaInicio)) {
                    return ['hora' => $horaSlot, 'disponible' => false];
                }
            }

            return ['hora' => $horaSlot, 'disponible' => true];
        }, $slots);
    }

    private function generarIcs($cita)
    {
        $dtStamp = now()->utc()->format('Ymd\THis\Z');
        $fecha = Carbon::parse($cita->fecha)->format('Ymd');
        $horaObj = Carbon::createFromFormat('H:i:s', $cita->hora);
        $dtStart = $fecha . 'T' . $horaObj->format('His');
        $dtEnd = $fecha . 'T' . $horaObj->copy()->addMinutes($cita->servicio->duracion)->format('His');

        $peluquero = $cita->peluquero->nombre . ' ' . $cita->peluquero->apellidos;
        $servicio = $cita->servicio->nombre;
        $precio = number_format($cita->servicio->precio, 2, ',', '.');
        $descripcion = "Servicio: {$servicio}\\nPeluquero: {$peluquero}\\nPrecio: {$precio}\u{20AC}\\nEstado: {$cita->estado}";

        return "BEGIN:VCALENDAR\r\n"
            . "VERSION:2.0\r\n"
            . "PRODID:-//ST BARBER//Reservas//ES\r\n"
            . "CALSCALE:GREGORIAN\r\n"
            . "METHOD:PUBLISH\r\n"
            . "BEGIN:VEVENT\r\n"
            . "UID:cita-{$cita->id_cita}@stbarber.com\r\n"
            . "DTSTAMP:{$dtStamp}\r\n"
            . "DTSTART:{$dtStart}\r\n"
            . "DTEND:{$dtEnd}\r\n"
            . "SUMMARY:ST BARBER \u{2014} {$servicio}\r\n"
            . "DESCRIPTION:{$descripcion}\r\n"
            . "LOCATION:ST BARBER - Calle Mayor 12\\, Badajoz\r\n"
            . "END:VEVENT\r\n"
            . "END:VCALENDAR\r\n";
    }
}
