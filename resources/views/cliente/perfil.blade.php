@extends('layouts.app')

@section('title', 'Mi perfil — ST BARBER')

@push('styles')
<style>
    .sb-page-header { background:#111;padding:44px 0 40px; }
    .sb-page-header h1 { font-size:clamp(22px,3.5vw,32px);font-weight:800;color:#fff;margin:0; }

    .sb-card { background:#fff;border:1px solid #E9ECEF;border-radius:14px;padding:28px; }
    .sb-card-title {
        font-size:15px;font-weight:700;color:#111;
        padding-bottom:16px;margin-bottom:20px;
        border-bottom:1px solid #F3F4F6;
        display:flex;align-items:center;gap:8px;
    }
    .sb-field-group { margin-bottom:18px; }
    .sb-field-label {
        display:block;font-size:13px;font-weight:600;
        color:#374151;margin-bottom:6px;
    }
    .sb-input {
        width:100%;border:1.5px solid #E9ECEF;border-radius:9px;
        padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;
        color:#111;outline:none;transition:border-color .2s;background:#fff;
    }
    .sb-input:focus { border-color:#111111; }
    .sb-input:disabled { background:#F9FAFB;color:#9CA3AF;cursor:not-allowed; }

    .btn-guardar {
        background:#111111;color:#fff;border:none;border-radius:10px;
        padding:11px 28px;font-size:14px;font-weight:700;cursor:pointer;
        font-family:'Inter',sans-serif;transition:background .2s;
    }
    .btn-guardar:hover { background:#333333; }

    .sb-avatar-grande {
        width:72px;height:72px;border-radius:50%;
        background:#111111;color:#fff;
        font-size:26px;font-weight:800;
        display:flex;align-items:center;justify-content:center;
    }
</style>
@endpush

@section('content')

<div class="sb-page-header">
    <div class="container">
        <div style="font-size:11px;font-weight:700;letter-spacing:2px;color:rgba(255,255,255,.5);text-transform:uppercase;margin-bottom:8px;">
            Área personal
        </div>
        <h1>Mi perfil</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-lg-3">
            <div class="sb-card text-center" style="padding:32px 24px;">
                <div class="sb-avatar-grande mx-auto mb-3">
                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                </div>
                <div style="font-size:16px;font-weight:800;color:#111;margin-bottom:2px;">
                    {{ $usuario->nombre }} {{ $usuario->apellidos }}
                </div>
                <div style="font-size:12.5px;color:#6B7280;font-weight:600;margin-bottom:16px;">
                    Cliente
                </div>
                <div style="font-size:12.5px;color:#6B7280;border-top:1px solid #F3F4F6;padding-top:14px;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-envelope" style="color:#111;"></i>
                        {{ $usuario->email }}
                    </div>
                    @if($usuario->telefono)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone" style="color:#111;"></i>
                            {{ $usuario->telefono }}
                        </div>
                    @endif
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3" style="color:#111;"></i>
                        Cliente desde {{ $usuario->fecha_registro->format('m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">

            <form method="POST" action="{{ route('perfil.actualizar') }}">
                @csrf @method('PUT')

                <div class="sb-card mb-4">
                    <div class="sb-card-title">
                        <i class="bi bi-person" style="color:#111;"></i>
                        Datos personales
                    </div>

                    @if($errors->any())
                        <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;gap:10px;">
                            <i class="bi bi-exclamation-circle-fill" style="color:#DC2626;flex-shrink:0;"></i>
                            <div style="font-size:13.5px;color:#991B1B;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="sb-field-group">
                                <label class="sb-field-label">Nombre <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="nombre" class="sb-input @error('nombre') border-danger @enderror"
                                       value="{{ old('nombre', $usuario->nombre) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="sb-field-group">
                                <label class="sb-field-label">Apellidos <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="apellidos" class="sb-input @error('apellidos') border-danger @enderror"
                                       value="{{ old('apellidos', $usuario->apellidos) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="sb-field-group">
                                <label class="sb-field-label">Correo electrónico <span style="color:#EF4444;">*</span></label>
                                <input type="email" name="email" class="sb-input @error('email') border-danger @enderror"
                                       value="{{ old('email', $usuario->email) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="sb-field-group">
                                <label class="sb-field-label">
                                    Teléfono
                                    <span style="color:#9CA3AF;font-weight:400;">(opcional)</span>
                                </label>
                                <input type="tel" name="telefono" class="sb-input @error('telefono') border-danger @enderror"
                                       value="{{ old('telefono', $usuario->telefono) }}"
                                       placeholder="600 000 000">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sb-card mb-4">
                    <div class="sb-card-title">
                        <i class="bi bi-lock" style="color:#111;"></i>
                        Cambiar contraseña
                        <span style="font-size:12px;color:#9CA3AF;font-weight:400;margin-left:4px;">(solo si quieres cambiarla)</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="sb-field-group mb-0">
                                <label class="sb-field-label">Contraseña actual</label>
                                <input type="password" name="password_actual" class="sb-input @error('password_actual') border-danger @enderror"
                                       placeholder="Tu contraseña actual"
                                       autocomplete="current-password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="sb-field-group mb-0">
                                <label class="sb-field-label">Nueva contraseña</label>
                                <input type="password" name="nueva_password" class="sb-input @error('nueva_password') border-danger @enderror"
                                       placeholder="Mínimo 8 caracteres"
                                       autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="sb-field-group mb-0">
                                <label class="sb-field-label">Repetir nueva contraseña</label>
                                <input type="password" name="nueva_password_confirmation" class="sb-input"
                                       placeholder="Repite la contraseña"
                                       autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3">
                    <a href="{{ route('citas.index') }}"
                       style="font-size:14px;font-weight:600;color:#6B7280;text-decoration:none;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-guardar">
                        <i class="bi bi-check-lg me-1"></i> Guardar cambios
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
