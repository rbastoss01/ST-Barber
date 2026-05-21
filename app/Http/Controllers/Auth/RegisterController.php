<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validar registro
        $datos = $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:150'],
            'email'     => ['required', 'email', 'max:200', 'unique:usuarios,email'],
            'telefono'  => ['nullable', 'string', 'regex:/^[0-9\s\+\-]{7,15}$/'],
            'password'  => ['required', 'confirmed', Password::min(8)],
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'nombre.max'         => 'El nombre no puede superar los 100 caracteres.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.max'      => 'Los apellidos no pueden superar los 150 caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Introduce un correo electrónico válido.',
            'email.unique'       => 'Este correo ya tiene una cuenta registrada.',
            'telefono.regex'     => 'Introduce un número de teléfono válido (7-15 dígitos).',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // Crear usuario
        $usuario = Usuario::create([
            'nombre'       => $datos['nombre'],
            'apellidos'    => $datos['apellidos'],
            'email'        => $datos['email'],
            'password'     => $datos['password'],
            'telefono'     => $datos['telefono'] ?? null,
            'tipo_usuario' => 'CLIENTE',
            'activo'       => true,
        ]);

        // Iniciar sesión
        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('citas.index')
            ->with('success', '¡Bienvenido, ' . $usuario->nombre . '!');
    }
}
