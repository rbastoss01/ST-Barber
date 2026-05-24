<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peluquero;
use Illuminate\Http\Request;

class PeluqueroController extends Controller
{
    public function index()
    {
        $peluqueros = Peluquero::withCount('citas')->orderBy('nombre')->get();
        return view('admin.peluqueros.index', compact('peluqueros'));
    }

    public function crear()
    {
        return view('admin.peluqueros.form', ['peluquero' => null]);
    }

    public function guardar(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:80',
            'apellidos' => 'required|string|max:120',
            'especialidad' => 'nullable|string|max:500',
        ]);

        $data['activo'] = true;
        Peluquero::create($data);

        return redirect()->route('admin.peluqueros.index')
            ->with('success', 'Peluquero creado correctamente.');
    }

    public function editar(int $id)
    {
        $peluquero = Peluquero::findOrFail($id);
        return view('admin.peluqueros.form', compact('peluquero'));
    }

    public function actualizar(Request $request, int $id)
    {
        $peluquero = Peluquero::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:80',
            'apellidos' => 'required|string|max:120',
            'especialidad' => 'nullable|string|max:500',
        ]);

        $peluquero->update($data);

        return redirect()->route('admin.peluqueros.index')
            ->with('success', 'Peluquero actualizado correctamente.');
    }

    public function eliminar(int $id)
    {
        $peluquero = Peluquero::findOrFail($id);

        try {
            $peluquero->delete();
            return redirect()->route('admin.peluqueros.index')
                ->with('success', 'Peluquero eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.peluqueros.index')
                ->with('error', 'No se puede eliminar el peluquero porque tiene citas asociadas.');
        }
    }

    public function toggleAusencia(int $id)
    {
        $peluquero = Peluquero::findOrFail($id);
        $peluquero->update(['ausente' => ! $peluquero->ausente]);

        $msg = $peluquero->ausente
            ? "{$peluquero->nombre} marcado como ausente."
            : "{$peluquero->nombre} disponible.";

        return redirect()->route('admin.peluqueros.index')->with('success', $msg);
    }
}
