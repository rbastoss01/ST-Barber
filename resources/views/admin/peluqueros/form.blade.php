@extends('layouts.admin')

@section('title', $peluquero ? 'Editar peluquero' : 'Nuevo peluquero')
@section('page-title', $peluquero ? 'Editar peluquero' : 'Nuevo peluquero')

@push('styles')
<style>
    .form-card {
        background:#fff;
        border:1px solid var(--sb-border);
        border-radius:var(--sb-radius);
        padding:28px 32px;
        max-width:640px;
    }
    .form-label { font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; }
    .form-hint  { font-size:12px; color:#9CA3AF; margin-top:4px; }
    .field-err  { font-size:12px; color:#DC2626; margin-top:4px; }

</style>
@endpush

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.peluqueros.index') }}"
       style="font-size:13px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
        <i class="bi bi-arrow-left"></i> Volver a peluqueros
    </a>
</div>

<form method="POST"
      action="{{ $peluquero ? route('admin.peluqueros.actualizar', $peluquero->id_peluquero) : route('admin.peluqueros.guardar') }}">
    @csrf
    @if($peluquero) @method('PUT') @endif

    <div class="form-card">
        <h2 style="font-size:16px;font-weight:700;color:#111;margin:0 0 24px;">
            {{ $peluquero ? 'Editar peluquero' : 'Crear nuevo peluquero' }}
        </h2>

        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $peluquero?->nombre) }}"
                       placeholder="Nombre" maxlength="80" required>
                @error('nombre')
                    <div class="field-err">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror"
                       value="{{ old('apellidos', $peluquero?->apellidos) }}"
                       placeholder="Apellidos" maxlength="120" required>
                @error('apellidos')
                    <div class="field-err">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Trabajo</label>
            <textarea name="especialidad" class="form-control @error('especialidad') is-invalid @enderror"
                      rows="3" placeholder="Descripción del trabajo del peluquero…"
                      maxlength="500">{{ old('especialidad', $peluquero?->especialidad) }}</textarea>
            @error('especialidad')
                <div class="field-err">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-sb">
                <i class="bi bi-check-lg me-1"></i>
                {{ $peluquero ? 'Guardar cambios' : 'Crear peluquero' }}
            </button>
            <a href="{{ route('admin.peluqueros.index') }}"
               class="d-inline-flex align-items-center gap-1 px-4 py-2 border rounded text-decoration-none"
               style="font-size:13px;color:#6B7280;border-radius:8px!important;">
                Cancelar
            </a>
        </div>
    </div>
</form>

@endsection

