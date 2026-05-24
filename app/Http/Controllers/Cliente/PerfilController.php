<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        return view('cliente.perfil', ['usuario' => auth()->user()]);
    }

    public function actualizar(Request $request)
    {
        $usuario = auth()->user();

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:200|unique:usuarios,email,'.$usuario->id,
            'telefono' => 'nullable|string|regex:/^[0-9\s\+\-]{7,15}$/',
        ]);

        $usuario->update($datos);

        if ($request->filled('nueva_password')) {
            $request->validate([
                'password_actual' => 'required',
                'nueva_password' => 'required|confirmed|min:8',
            ]);

            if (! Hash::check($request->password_actual, $usuario->password)) {
                return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
            }

            $usuario->update(['password' => $request->nueva_password]);
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
