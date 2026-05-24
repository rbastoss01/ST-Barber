@extends('layouts.admin')

@section('title', 'Horarios')
@section('page-title', 'Horarios de apertura')

@push('styles')
<style>
    .horario-card {
        background:#fff;
        border:1px solid var(--sb-border);
        border-radius:var(--sb-radius);
        padding:0;
        overflow:hidden;
    }
    .horario-head {
        padding:20px 24px;
        border-bottom:1px solid #F3F4F6;
    }
    .horario-body { padding:8px 0; }

    .dia-row {
        display:grid;
        grid-template-columns: 130px 1fr 1fr auto;
        align-items:center;
        gap:16px;
        padding:12px 24px;
        border-bottom:1px solid #F9FAFB;
        transition:background .15s;
    }
    .dia-row:last-child { border-bottom:none; }
    .dia-row:hover { background:#FAFAFA; }

    .dia-nombre {
        font-size:13.5px; font-weight:700; color:#111;
        display:flex; align-items:center; gap:10px;
    }

    .toggle-track {
        width:36px; height:20px; border-radius:10px;
        background:#E5E7EB; position:relative; transition:background .2s; flex-shrink:0;
        cursor:pointer;
    }
    .toggle-track.on { background:var(--sb-gold); }
    .toggle-knob {
        position:absolute; top:2px; left:2px;
        width:16px; height:16px; border-radius:50%;
        background:#fff; transition:left .2s; box-shadow:0 1px 3px rgba(0,0,0,.2);
    }
    .toggle-track.on .toggle-knob { left:18px; }

    .time-group {
        display:flex; align-items:center; gap:8px;
        opacity:1; transition:opacity .2s;
    }
    .time-group.disabled { opacity:.35; pointer-events:none; }
    .time-sep { font-size:12px; color:#9CA3AF; font-weight:600; }

    .dia-estado {
        font-size:12px; font-weight:600;
        padding:3px 10px; border-radius:20px;
        white-space:nowrap;
    }
    .dia-estado.abierto   { background:#DCFCE7; color:#166534; }
    .dia-estado.cerrado   { background:#F3F4F6; color:#6B7280; }

    @media (max-width:575.98px) {
        .dia-row {
            grid-template-columns: 1fr auto;
            grid-template-rows: auto auto;
            gap:10px;
        }
        .dia-nombre { grid-column: 1; }
        .dia-estado { grid-column: 2; grid-row: 1; }
        .time-group { grid-column: 1 / -1; }
    }
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('admin.horarios.actualizar') }}">
    @csrf @method('PUT')

    <div class="horario-card mb-3">
        <div class="horario-head d-flex align-items-center justify-content-between">
            <div>
                <div style="font-size:15px;font-weight:700;color:#111;">
                    <i class="bi bi-clock me-2" style="color:var(--sb-gold);"></i>Horario semanal
                </div>
                <div style="font-size:12.5px;color:#6B7280;margin-top:3px;">
                    Activa los días de apertura e indica el horario. Los clientes solo podrán reservar en las franjas activas.
                </div>
            </div>
        </div>

        <div class="horario-body">
            @php
                $diasNombres = \App\Models\Horario::diasNombres();
            @endphp
            @for ($dia = 1; $dia <= 7; $dia++)
                @php
                    $h      = $horarios->get($dia);
                    $activo = $h && $h->activo;
                    $inicio = $h?->hora_inicio ? \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') : '09:00';
                    $fin    = $h?->hora_fin    ? \Carbon\Carbon::parse($h->hora_fin)->format('H:i')    : '20:00';
                @endphp
                <div class="dia-row" id="fila-{{ $dia }}">
                    <div class="dia-nombre">
                        <div class="toggle-track {{ $activo ? 'on' : '' }}"
                             id="track-{{ $dia }}"
                             onclick="toggleDia({{ $dia }})">
                            <div class="toggle-knob"></div>
                        </div>
                        <input type="checkbox"
                               name="dias[{{ $dia }}]"
                               id="check-{{ $dia }}"
                               class="d-none"
                               {{ $activo ? 'checked' : '' }}
                               onchange="syncDia({{ $dia }})">
                        {{ $diasNombres[$dia] }}
                    </div>

                    <div class="time-group {{ $activo ? '' : 'disabled' }}" id="horas-{{ $dia }}">
                        <label style="font-size:12px;color:#6B7280;font-weight:600;white-space:nowrap;">Apertura</label>
                        <input type="time" name="dias[{{ $dia }}][hora_inicio]"
                               class="form-control form-control-sm"
                               style="width:110px;"
                               value="{{ $inicio }}"
                               {{ $activo ? '' : 'disabled' }}>
                        <span class="time-sep">—</span>
                        <label style="font-size:12px;color:#6B7280;font-weight:600;white-space:nowrap;">Cierre</label>
                        <input type="time" name="dias[{{ $dia }}][hora_fin]"
                               class="form-control form-control-sm"
                               style="width:110px;"
                               value="{{ $fin }}"
                               {{ $activo ? '' : 'disabled' }}>
                    </div>

                    <div>
                        <span class="dia-estado {{ $activo ? 'abierto' : 'cerrado' }}"
                              id="badge-{{ $dia }}">
                            {{ $activo ? 'Abierto' : 'Cerrado' }}
                        </span>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn-sb">
            <i class="bi bi-check-lg me-1"></i> Guardar horarios
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
function toggleDia(dia) {
    const check = document.getElementById('check-' + dia);
    check.checked = !check.checked;
    syncDia(dia);
}

function syncDia(dia) {
    const check  = document.getElementById('check-' + dia);
    const track  = document.getElementById('track-' + dia);
    const horas  = document.getElementById('horas-' + dia);
    const badge  = document.getElementById('badge-' + dia);
    const inputs = horas.querySelectorAll('input[type="time"]');

    if (check.checked) {
        track.classList.add('on');
        horas.classList.remove('disabled');
        inputs.forEach(i => i.disabled = false);
        badge.textContent = 'Abierto';
        badge.className = 'dia-estado abierto';
    } else {
        track.classList.remove('on');
        horas.classList.add('disabled');
        inputs.forEach(i => i.disabled = true);
        badge.textContent = 'Cerrado';
        badge.className = 'dia-estado cerrado';
    }
}
</script>
@endpush
