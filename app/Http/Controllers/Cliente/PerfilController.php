<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
            'nombre'    => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:150'],
            'email'     => ['required', 'email', 'max:200', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
            'telefono'  => ['nullable', 'string', 'regex:/^[0-9\s\+\-]{7,15}$/'],
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.unique'       => 'Ese correo ya está en uso por otra cuenta.',
            'telefono.regex'     => 'Introduce un número de teléfono válido.',
        ]);

        $usuario->update($datos);

        if ($request->filled('nueva_password')) {
            $request->validate([
                'password_actual'  => ['required'],
                'nueva_password'   => ['required', 'confirmed', Password::min(8)],
            ], [
                'password_actual.required'  => 'Introduce tu contraseña actual.',
                'nueva_password.confirmed'  => 'Las contraseñas no coinciden.',
                'nueva_password.min'        => 'La nueva contraseña debe tener al menos 8 caracteres.',
            ]);

            if (! Hash::check($request->password_actual, $usuario->password)) {
                return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
            }

            $usuario->update(['password' => $request->nueva_password]);
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
