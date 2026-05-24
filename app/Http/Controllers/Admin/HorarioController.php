<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::orderBy('dia_semana')->get()->keyBy('dia_semana');
        return view('admin.horarios.index', compact('horarios'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'dias' => 'nullable|array',
            'dias.*.hora_inicio' => 'required_with:dias.*|date_format:H:i',
            'dias.*.hora_fin' => 'required_with:dias.*|date_format:H:i|after:dias.*.hora_inicio',
        ]);

        for ($dia = 1; $dia <= 7; $dia++) {
            $activo = isset($request->input('dias', [])[$dia]);

            if ($activo) {
                Horario::updateOrCreate(
                    ['dia_semana' => $dia],
                    [
                        'hora_inicio' => $request->input("dias.{$dia}.hora_inicio"),
                        'hora_fin' => $request->input("dias.{$dia}.hora_fin"),
                        'activo' => true,
                    ]
                );
            } else {
                Horario::where('dia_semana', $dia)->update(['activo' => false]);
            }
        }

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horarios actualizados correctamente.');
    }
}
