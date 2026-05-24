@extends('layouts.app')

@section('title', 'Mis citas — ST BARBER')

@push('styles')
<style>
    .sb-page-header {
        background: #111;
        padding: 44px 0 40px;
    }
    .sb-page-header h1 { font-size:clamp(24px,4vw,36px);font-weight:800;color:#fff;margin:0; }

    .sb-tabs { border-bottom:2px solid #E9ECEF; margin-bottom:32px; }
    .sb-tab-btn {
        background:none;border:none;padding:14px 24px;
        font-size:14px;font-weight:600;color:#9CA3AF;cursor:pointer;
        border-bottom:2px solid transparent;margin-bottom:-2px;
        transition:color .2s,border-color .2s;font-family:'Inter',sans-serif;
    }
    .sb-tab-btn.active { color:#111111;border-bottom-color:#111111; }
    .sb-tab-btn:hover:not(.active) { color:#374151; }

    .sb-cita-card {
        background:#fff;border:1px solid #E9ECEF;border-radius:14px;
        padding:22px 24px;margin-bottom:14px;
        display:flex;flex-wrap:wrap;align-items:center;gap:16px;
        transition:box-shadow .2s;
    }
    .sb-cita-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.06); }

    .sb-cita-fecha-bloque {
        width:60px;height:64px;border-radius:12px;
        background:#111111;flex-shrink:0;
        display:flex;flex-direction:column;align-items:center;justify-content:center;
    }
    .sb-cita-dia   { font-size:24px;font-weight:800;color:#fff;line-height:1; }
    .sb-cita-mes   { font-size:10px;font-weight:700;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:1px; }

    .sb-cita-info  { flex:1;min-width:180px; }
    .sb-cita-servicio { font-size:15px;font-weight:700;color:#111;margin-bottom:4px; }
    .sb-cita-meta     { font-size:13px;color:#6B7280;display:flex;flex-wrap:wrap;gap:10px;align-items:center; }

    .sb-badge {
        display:inline-flex;align-items:center;gap:4px;
        border-radius:999px;padding:3px 10px;font-size:11.5px;font-weight:700;
        text-transform:uppercase;letter-spacing:.5px;
    }
    .sb-badge-confirmada { background:rgba(22,163,74,.12);  color:#14532D; }
    .sb-badge-cancelada  { background:rgba(239,68,68,.1);   color:#7F1D1D; }

    .sb-cita-precio { font-size:18px;font-weight:800;color:#111111;white-space:nowrap; }

    .sb-cita-acciones { display:flex;gap:8px;flex-shrink:0; }

    .btn-accion {
        display:inline-flex;align-items:center;gap:5px;
        border-radius:8px;padding:7px 14px;font-size:12.5px;font-weight:600;
        border:1.5px solid;cursor:pointer;text-decoration:none;font-family:'Inter',sans-serif;
        transition:all .2s;background:transparent;
    }
    .btn-accion-edit  { border-color:#E9ECEF;color:#374151; }
    .btn-accion-edit:hover  { background:#F3F4F6;color:#111; }
    .btn-accion-cancel{ border-color:#FECACA;color:#DC2626; }
    .btn-accion-cancel:hover { background:#FEF2F2;color:#DC2626; }
    .btn-accion-ics   { border-color:#E9ECEF;color:#6B7280; }
    .btn-accion-ics:hover { background:#F3F4F6;color:#374151; }

    .sb-empty {
        text-align:center;padding:72px 20px;
        background:#fff;border:1px solid #E9ECEF;border-radius:14px;
    }
    .sb-empty i   { font-size:52px;color:#E9ECEF;display:block;margin-bottom:16px; }
    .sb-empty h3  { font-size:18px;font-weight:700;color:#374151;margin-bottom:8px; }
    .sb-empty p   { font-size:14px;color:#9CA3AF;margin-bottom:24px; }
</style>
@endpush

@section('content')

<div class="sb-page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:8px;">
                    Área personal
                </div>
                <h1>Mis citas</h1>
            </div>
            <a href="{{ route('citas.reservar') }}" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#111;border:none;border-radius:10px;padding:11px 22px;font-size:14px;font-weight:700;text-decoration:none;transition:background .2s;" onmouseout="this.style.background='#fff'">
                <i class="bi bi-calendar-plus"></i> Nueva cita
            </a>
        </div>
    </div>
</div>

<div class="container py-4">

    <div class="sb-tabs">
        <button class="sb-tab-btn active" id="tab-proximas" onclick="mostrarTab('proximas')">
            <i class="bi bi-calendar-check me-1"></i>
            Próximas
            @if($proximas->isNotEmpty())
                <span style="background:#111111;color:#fff;border-radius:999px;padding:1px 7px;font-size:11px;margin-left:4px;">
                    {{ $proximas->count() }}
                </span>
            @endif
        </button>
        <button class="sb-tab-btn" id="tab-pasadas" onclick="mostrarTab('pasadas')">
            <i class="bi bi-clock-history me-1"></i>
            Pasadas
        </button>
    </div>

    <div id="panel-proximas">
        @forelse($proximas as $cita)
            <div class="sb-cita-card">
                <div class="sb-cita-fecha-bloque">
                    <div class="sb-cita-dia">{{ $cita->fecha->format('d') }}</div>
                    <div class="sb-cita-mes">{{ $cita->fecha->format('m') }}</div>
                </div>

                <div class="sb-cita-info">
                    <div class="sb-cita-servicio">{{ $cita->servicio->nombre }}</div>
                    <div class="sb-cita-meta">
                        <span><i class="bi bi-clock me-1"></i>{{ substr($cita->hora, 0, 5) }}</span>
                        <span><i class="bi bi-scissors me-1"></i>{{ $cita->peluquero->nombre }}</span>
                        <span><i class="bi bi-hourglass me-1"></i>{{ $cita->servicio->duracion }} min</span>
                        @if($cita->observaciones)
                            <span title="{{ $cita->observaciones }}">
                                <i class="bi bi-chat-dots me-1"></i>
                                <span style="font-style:italic;">{{ Str::limit($cita->observaciones, 30) }}</span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-column align-items-end gap-2" style="flex-shrink:0;">
                    @php
                    if ($cita->estado === 'CONFIRMADA') {
                        $badgeClass = 'sb-badge-confirmada';
                    } else {
                        $badgeClass = 'sb-badge-cancelada';
                    }
                    @endphp
                    <span class="sb-badge {{ $badgeClass }}">{{ $cita->estado }}</span>
                    <span class="sb-cita-precio">{{ number_format($cita->servicio->precio, 2, ',', '.') }} €</span>
                </div>

                @if($cita->estado !== 'CANCELADA')
                <div class="sb-cita-acciones">
                    <a href="{{ route('citas.editar', $cita->id_cita) }}"
                       class="btn-accion btn-accion-edit">
                        <i class="bi bi-pencil"></i> Modificar
                    </a>

                    <form method="POST" action="{{ route('citas.cancelar', $cita->id_cita) }}"
                          x-data
                          @submit.prevent="
                              Swal.fire({
                                  title:'¿Cancelar esta cita?',
                                  text:'Esta acción no se puede deshacer.',
                                  icon:'warning',
                                  showCancelButton:true,
                                  confirmButtonColor:'#111111',
                                  cancelButtonColor:'#E5E7EB',
                                  confirmButtonText:'Sí, cancelar',
                                  cancelButtonText:'No, mantener',
                              }).then(r => { if(r.isConfirmed) $el.submit(); })">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-accion btn-accion-cancel">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                    </form>

                    <a href="{{ route('citas.ics', $cita->id_cita) }}"
                       class="btn-accion btn-accion-ics" title="Añadir al calendario">
                        <i class="bi bi-calendar-event"></i>
                    </a>
                </div>
                @endif
            </div>
        @empty
            <div class="sb-empty">
                <i class="bi bi-calendar-x"></i>
                <h3>No tienes citas próximas</h3>
                <p>Reserva tu próxima cita online.</p>
                <a href="{{ route('citas.reservar') }}"
                   style="display:inline-flex;align-items:center;gap:8px;background:#111111;color:#fff;border-radius:10px;padding:11px 24px;font-size:14px;font-weight:700;text-decoration:none;">
                    <i class="bi bi-calendar-plus"></i> Reservar ahora
                </a>
            </div>
        @endforelse
    </div>

    <div id="panel-pasadas" style="display:none;">
        @forelse($pasadas as $cita)
            <div class="sb-cita-card" style="opacity:.85;">
                <div class="sb-cita-fecha-bloque" style="background:#F3F4F6;">
                    <div class="sb-cita-dia" style="color:#9CA3AF;">{{ $cita->fecha->format('d') }}</div>
                    <div class="sb-cita-mes" style="color:#9CA3AF;">{{ $cita->fecha->format('m') }}</div>
                </div>

                <div class="sb-cita-info">
                    <div class="sb-cita-servicio">{{ $cita->servicio->nombre }}</div>
                    <div class="sb-cita-meta">
                        <span><i class="bi bi-clock me-1"></i>{{ substr($cita->hora, 0, 5) }}</span>
                        <span><i class="bi bi-scissors me-1"></i>{{ $cita->peluquero->nombre }}</span>
                        @php $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']; @endphp
                        <span><i class="bi bi-calendar3 me-1"></i>{{ $cita->fecha->day }} {{ $meses[$cita->fecha->month - 1] }} {{ $cita->fecha->year }}</span>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-end gap-2" style="flex-shrink:0;">
                    @php
                    if ($cita->estado === 'CONFIRMADA') {
                        $badgeClass = 'sb-badge-confirmada';
                    } else {
                        $badgeClass = 'sb-badge-cancelada';
                    }
                    @endphp
                    <span class="sb-badge {{ $badgeClass }}">{{ $cita->estado }}</span>
                    <span style="font-size:16px;font-weight:700;color:#9CA3AF;">
                        {{ number_format($cita->servicio->precio, 2, ',', '.') }} €
                    </span>
                </div>

            </div>
        @empty
            <div class="sb-empty">
                <i class="bi bi-clock-history"></i>
                <h3>Sin historial aún</h3>
                <p>Aquí aparecerán tus citas pasadas.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection

@push('scripts')
<script>
    function mostrarTab(tab) {
        document.getElementById('panel-proximas').style.display = tab === 'proximas' ? 'block' : 'none';
        document.getElementById('panel-pasadas').style.display  = tab === 'pasadas'  ? 'block' : 'none';
        document.getElementById('tab-proximas').classList.toggle('active', tab === 'proximas');
        document.getElementById('tab-pasadas').classList.toggle('active', tab === 'pasadas');
    }
</script>
@endpush
