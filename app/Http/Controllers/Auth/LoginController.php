<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors(['login' => $validator->errors()->first()])
                ->withInput()
                ->with('_form_type', 'login');
        }

        $credenciales = $validator->validated();

        $usuario = Usuario::where('email', $credenciales['email'])->first();

        if ($usuario && ! $usuario->activo) {
            return back()
                ->withErrors(['login' => 'Tu cuenta está desactivada. Contacta con el administrador.'])
                ->withInput()
                ->with('_form_type', 'login');
        }

        if (Auth::attempt($credenciales, $request->has('remember'))) {
            if (auth()->user()->esAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('citas.index');
        }

        return back()
            ->withErrors(['login' => 'El correo o la contraseña no son correctos.'])
            ->withInput()
            ->with('_form_type', 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('inicio')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
