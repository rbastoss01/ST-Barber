@extends('layouts.app')

@section('title', 'Recuperar contraseña — ST BARBER')

@section('content')

<div style="display:flex; align-items:center; justify-content:center; background:#F5F5F5; padding:80px 16px 48px;">
    <div style="width:100%; max-width:420px;">

        <div class="text-center mb-4">
            <a href="{{ route('inicio') }}"
               style="font-size:13px;font-weight:800;letter-spacing:5px;color:#111111;text-decoration:none;text-transform:uppercase;">
                ST BARBER
            </a>
            <h1 style="font-size:22px;font-weight:800;color:#111;margin-top:18px;margin-bottom:6px;">
                Recuperar contraseña
            </h1>
            <p style="font-size:14px;color:#6B7280;margin:0;line-height:1.55;">
                Recibirás un enlace de recuperación en breve.
            </p>
        </div>

        <div style="background:#fff;border:1px solid #E9ECEF;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,.05);">
            @if(session('success'))
                <div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;">
                    <i class="bi bi-check-circle-fill" style="color:#16A34A;font-size:16px;margin-top:1px;flex-shrink:0;"></i>
                    <span style="font-size:13.5px;color:#166534;font-weight:500;">
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            @if($errors->any())
                <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;">
                    <i class="bi bi-exclamation-circle-fill" style="color:#DC2626;font-size:16px;margin-top:1px;flex-shrink:0;"></i>
                    <div style="font-size:13.5px;color:#991B1B;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div style="margin-bottom:20px;">
                    <label for="email" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Correo electrónico
                    </label>
                    <div style="display:flex;align-items:center;border:1.5px solid {{ $errors->has('email') ? '#EF4444' : '#E9ECEF' }};border-radius:9px;overflow:hidden;background:#fff;transition:border-color .2s;" onfocusin="this.style.borderColor='#111111'" onfocusout="this.style.borderColor='{{ $errors->has('email') ? '#EF4444' : '#E9ECEF' }}'">
                        <span style="padding:0 12px;color:#9CA3AF;font-size:15px;flex-shrink:0;">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" autocomplete="email" required style="flex:1;border:none;outline:none;padding:11px 12px 11px 0;font-size:14px;font-family:'Inter',sans-serif;color:#111;background:transparent;">
                    </div>
                </div>
                <button type="submit" style="display:block;width:100%;background:#111111;color:#fff;border:none;border-radius:10px;padding:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:background .2s;" onmouseover="this.style.background='#333333'" onmouseout="this.style.background='#111111'">
                    Enviar enlace de recuperación
                </button>
            </form>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('inicio') }}" style="font-size:13.5px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:6px;" onmouseover="this.style.color='#111111'" onmouseout="this.style.color='#6B7280'">
                <i class="bi bi-arrow-left"></i>
                Volver al inicio
            </a>
        </div>

    </div>
</div>

@endsection
