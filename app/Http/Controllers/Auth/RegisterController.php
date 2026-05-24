<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string',
            'password' => 'required|confirmed|min:8',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => $request->password,
            'telefono' => $request->telefono,
            'tipo_usuario' => 'CLIENTE',
            'activo' => true,
        ]);

        Auth::login($usuario);

        return redirect()->route('citas.index')
            ->with('success', '¡Bienvenido, ' . $usuario->nombre . '!');
    }
}