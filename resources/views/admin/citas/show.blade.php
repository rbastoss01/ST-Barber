@extends('layouts.admin')

@section('title', 'Detalle de cita')
@section('page-title', 'Detalle de cita')

@push('styles')
<style>
    .detail-card { background:#fff; border:1px solid var(--sb-border); border-radius:var(--sb-radius); padding:24px; }
    .detail-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }
    @media(max-width:575px){ .detail-grid{ grid-template-columns:1fr; } }
    .detail-item label { display:block; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#9CA3AF; margin-bottom:4px; }
    .detail-item .val  { font-size:15px; font-weight:600; color:#111; }

    .sb-badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:12.5px; font-weight:700; }
    .sb-badge-c { background:#DCFCE7; color:#166534; }
    .sb-badge-x { background:#FEE2E2; color:#991B1B; }

    .form-section { background:#fff; border:1px solid var(--sb-border); border-radius:var(--sb-radius); padding:24px; }
    .section-title { font-size:14px; font-weight:700; color:#111; margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid #F3F4F6; display:flex; align-items:center; gap:7px; }

    .btn-confirmar { background:#16A34A; border:none; color:#fff; font-weight:700; font-size:13px; border-radius:8px; padding:9px 20px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:background .2s; }
    .btn-confirmar:hover { background:#15803D; }
    .btn-ics { background:#1D4ED8; border:none; color:#fff; font-weight:600; font-size:13px; border-radius:8px; padding:9px 20px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; transition:background .2s; }
    .btn-ics:hover { background:#1E40AF; color:#fff; }
    .btn-del { background:#DC2626; border:none; color:#fff; font-weight:600; font-size:13px; border-radius:8px; padding:9px 20px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:background .2s; }
    .btn-del:hover { background:#B91C1C; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.citas.index') }}"
       style="font-size:13px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
        <i class="bi bi-arrow-left"></i> Volver a citas
    </a>
</div>

<div class="row g-3">

    <div class="col-lg-5">
        <div class="detail-card mb-3">
            <div class="section-title">
                <i class="bi bi-calendar3" style="color:var(--sb-gold);"></i>
                Información de la cita
                <span class="ms-auto">
                    @if($cita->estado === 'CONFIRMADA')
                        <span class="sb-badge sb-badge-c">Confirmada</span>
                    @else
                        <span class="sb-badge sb-badge-x">Cancelada</span>
                    @endif
                </span>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <label>Fecha</label>
                    <div class="val">{{ $cita->fecha->format('d/m/Y') }}</div>
                </div>
                <div class="detail-item">
                    <label>Hora</label>
                    <div class="val">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</div>
                </div>
                <div class="detail-item">
                    <label>Cliente</label>
                    <div class="val">{{ $cita->usuario->nombre }} {{ $cita->usuario->apellidos }}</div>
                    <div style="font-size:12.5px;color:#9CA3AF;">{{ $cita->usuario->email }}</div>
                </div>
                <div class="detail-item">
                    <label>Teléfono</label>
                    <div class="val">{{ $cita->usuario->telefono ?? '—' }}</div>
                </div>
                <div class="detail-item">
                    <label>Peluquero</label>
                    <div class="val">{{ $cita->peluquero->nombre }} {{ $cita->peluquero->apellidos }}</div>
                </div>
                <div class="detail-item">
                    <label>Servicio</label>
                    <div class="val">{{ $cita->servicio->nombre }}</div>
                    <div style="font-size:12.5px;color:#9CA3AF;">{{ $cita->servicio->duracion }} min · {{ number_format($cita->servicio->precio, 2) }} €</div>
                </div>
            </div>

            @if($cita->observaciones)
            <div class="mt-3 pt-3" style="border-top:1px solid #F3F4F6;">
                <label style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9CA3AF;">Observaciones</label>
                <p style="font-size:14px;color:#374151;margin:4px 0 0;">{{ $cita->observaciones }}</p>
            </div>
            @endif
        </div>

        <div class="detail-card">
            <div class="section-title"><i class="bi bi-lightning" style="color:var(--sb-gold);"></i> Acciones</div>
            <div class="d-flex flex-wrap gap-2">

                <form method="POST" action="{{ route('admin.citas.eliminar', $cita->id_cita) }}" id="formEliminar" onsubmit="return false;">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-del" id="btnEliminar">
                        <i class="bi bi-trash3"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="form-section">
            <div class="section-title"><i class="bi bi-pencil" style="color:var(--sb-gold);"></i> Editar cita</div>

            <form method="POST" action="{{ route('admin.citas.actualizar', $cita->id_cita) }}">
                @csrf @method('PUT')

                @if($errors->any())
                    <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:12px 16px;margin-bottom:18px;">
                        @foreach($errors->all() as $error)
                            <div style="font-size:13px;color:#991B1B;">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" class="form-control"
                               value="{{ old('fecha', $cita->fecha->toDateString()) }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Hora <span class="text-danger">*</span></label>
                        <input type="time" name="hora" class="form-control"
                               value="{{ old('hora', \Carbon\Carbon::parse($cita->hora)->format('H:i')) }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Peluquero <span class="text-danger">*</span></label>
                        <select name="id_peluquero" class="form-select" required>
                            @foreach($peluqueros as $p)
                                <option value="{{ $p->id_peluquero }}"
                                    @selected(old('id_peluquero', $cita->id_peluquero) == $p->id_peluquero)>
                                    {{ $p->nombre }} {{ $p->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Servicio <span class="text-danger">*</span></label>
                        <select name="id_servicio" class="form-select" required>
                            @foreach($servicios as $s)
                                <option value="{{ $s->id_servicio }}"
                                    @selected(old('id_servicio', $cita->id_servicio) == $s->id_servicio)>
                                    {{ $s->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-select" required>
                            <option value="CONFIRMADA" @selected(old('estado', $cita->estado) === 'CONFIRMADA')>Confirmada</option>
                            <option value="CANCELADA"  @selected(old('estado', $cita->estado) === 'CANCELADA')>Cancelada</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label" style="font-size:12.5px;font-weight:600;">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3"
                                  placeholder="Notas adicionales…">{{ old('observaciones', $cita->observaciones) }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-sb">
                            <i class="bi bi-floppy me-1"></i> Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btnEliminar = document.getElementById('btnEliminar');
    if (btnEliminar) { btnEliminar.addEventListener('click', function () {
        Swal.fire({
            title: '¿Eliminar esta cita?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then(function (result) {
            if (result.isConfirmed) document.getElementById('formEliminar').submit();
        });
    }); }

});
</script>
@endpush
