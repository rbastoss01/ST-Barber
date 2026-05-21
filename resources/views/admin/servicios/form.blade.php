@extends('layouts.admin')

@section('title', $servicio ? 'Editar servicio' : 'Nuevo servicio')
@section('page-title', $servicio ? 'Editar servicio' : 'Nuevo servicio')

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
    <a href="{{ route('admin.servicios.index') }}"
       style="font-size:13px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
        <i class="bi bi-arrow-left"></i> Volver a servicios
    </a>
</div>

<form method="POST"
      action="{{ $servicio ? route('admin.servicios.actualizar', $servicio->id_servicio) : route('admin.servicios.guardar') }}">
    @csrf
    @if($servicio) @method('PUT') @endif

    <div class="form-card">
        <h2 style="font-size:16px;font-weight:700;color:#111;margin:0 0 24px;">
            {{ $servicio ? 'Editar servicio' : 'Crear nuevo servicio' }}
        </h2>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $servicio?->nombre) }}"
                   placeholder="Corte de pelo, Barba, Afeitado…" maxlength="120" required>
            @error('nombre')
                <div class="field-err">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                      rows="3" placeholder="Descripción opcional del servicio…"
                      maxlength="500">{{ old('descripcion', $servicio?->descripcion) }}</textarea>
            @error('descripcion')
                <div class="field-err">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <label class="form-label">Precio (€)</label>
                <div style="position:relative;">
                    <input type="number" name="precio" step="0.01" min="0" max="9999.99"
                           class="form-control @error('precio') is-invalid @enderror"
                           value="{{ old('precio', $servicio?->precio) }}"
                           placeholder="0.00" required
                           style="padding-right:32px;">
                    <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:14px;">€</span>
                </div>
                @error('precio')
                    <div class="field-err">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label class="form-label">Duración (minutos)</label>
                <div style="position:relative;">
                    <input type="number" name="duracion" min="15" max="480" step="5"
                           class="form-control @error('duracion') is-invalid @enderror"
                           value="{{ old('duracion', $servicio?->duracion) }}"
                           placeholder="30" required
                           style="padding-right:40px;">
                    <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:13px;">min</span>
                </div>
                @error('duracion')
                    <div class="field-err">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-sb">
                <i class="bi bi-check-lg me-1"></i>
                {{ $servicio ? 'Guardar cambios' : 'Crear servicio' }}
            </button>
            <a href="{{ route('admin.servicios.index') }}"
               class="d-inline-flex align-items-center gap-1 px-4 py-2 border rounded text-decoration-none"
               style="font-size:13px;color:#6B7280;border-radius:8px!important;">
                Cancelar
            </a>
        </div>
    </div>
</form>

@endsection

