<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ClienteAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::where('tipo_usuario', 'CLIENTE')->withCount('citas');

        if ($request->filled('buscar')) {
            $term = '%'.$request->buscar.'%';
            $query->where(function($q) use ($term) {
                $q->where('nombre', 'like', $term)
                  ->orWhere('apellidos', 'like', $term)
                  ->orWhere('email', 'like', $term);
            });
        }

        $clientes = $query->orderBy('apellidos')->orderBy('nombre')->paginate(20)->withQueryString();

        return view('admin.clientes.index', compact('clientes'));
    }

    public function show(int $id)
    {
        $cliente = Usuario::where('tipo_usuario', 'CLIENTE')->findOrFail($id);
        $citas = $cliente->citas()
            ->with(['peluquero', 'servicio'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('admin.clientes.show', compact('cliente', 'citas'));
    }

    public function eliminar(int $id)
    {
        $cliente = Usuario::where('tipo_usuario', 'CLIENTE')->findOrFail($id);

        try {
            $cliente->delete();
            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene citas asociadas.');
        }
    }
}
