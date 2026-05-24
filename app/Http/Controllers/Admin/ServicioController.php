<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function crear()
    {
        return view('admin.servicios.form', ['servicio' => null]);
    }

    public function guardar(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:120|unique:servicios,nombre',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0|max:9999.99',
            'duracion' => 'required|integer|min:15|max:480',
        ]);

        $data['activo'] = true;
        Servicio::create($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function editar(int $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.form', compact('servicio'));
    }

    public function actualizar(Request $request, int $id)
    {
        $servicio = Servicio::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:120|unique:servicios,nombre,'.$id.',id_servicio',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0|max:9999.99',
            'duracion' => 'required|integer|min:15|max:480',
        ]);

        $servicio->update($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function eliminar(int $id)
    {
        $servicio = Servicio::findOrFail($id);

        try {
            $servicio->delete();
            return redirect()->route('admin.servicios.index')
                ->with('success', 'Servicio eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.servicios.index')
                ->with('error', 'No se puede eliminar el servicio porque tiene citas asociadas.');
        }
    }
}
