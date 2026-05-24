@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .kpi-card {
        background: #fff;
        border: 1px solid var(--sb-border);
        border-radius: var(--sb-radius);
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: box-shadow .2s;
    }
    .kpi-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    .kpi-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        background: #F3F4F6;
        color: #111111;
        font-size: 22px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .kpi-val  { font-size: 26px; font-weight: 800; color: #111; line-height: 1; }
    .kpi-lbl  { font-size: 12.5px; color: #6B7280; font-weight: 500; margin-top: 3px; }

    .status-card {
        background: #fff;
        border: 1px solid var(--sb-border);
        border-radius: var(--sb-radius);
        padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .status-dot {
        width: 40px; height: 40px; border-radius: 10px;
        font-size: 18px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .dot-confirmed { background: #DCFCE7; color: #16A34A; }
    .dot-cancelled { background: #FEE2E2; color: #DC2626; }
    .status-val { font-size: 22px; font-weight: 800; color: #111; line-height: 1; }
    .status-lbl { font-size: 12px; color: #6B7280; font-weight: 500; margin-top: 2px; }

    .panel { background:#fff; border:1px solid var(--sb-border); border-radius:var(--sb-radius); }
    .panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid #F3F4F6;
        display: flex; align-items: center; justify-content: space-between;
        gap: 8px;
    }
    .panel-title { font-size: 14px; font-weight: 700; color: #111; display:flex; align-items:center; gap:7px; }
    .panel-body  { padding: 0 20px 20px; }

    .sb-table { width:100%; border-collapse:collapse; font-size:13.5px; }
    .sb-table th { padding:10px 12px; font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#9CA3AF; background:#FAFAFA; border-bottom:1px solid #F3F4F6; white-space:nowrap; }
    .sb-table td { padding:10px 12px; border-bottom:1px solid #F9FAFB; color:#374151; vertical-align:middle; }
    .sb-table tr:last-child td { border-bottom:none; }
    .sb-table tbody tr:hover td { background:#FAFAFA; }

    .sb-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11.5px; font-weight:600; }
    .sb-badge-c { background:#DCFCE7; color:#166534; }
    .sb-badge-x { background:#FEE2E2; color:#991B1B; }

    .proxima-item {
        display:flex; align-items:center; gap:10px;
        padding:10px 0; border-bottom:1px solid #F9FAFB;
    }
    .proxima-item:last-child { border-bottom:none; }
    .proxima-fecha {
        min-width:46px; height:46px; border-radius:10px;
        background:#F3F4F6; color:#111111;
        text-align:center; display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        font-weight:700; line-height:1.1; flex-shrink:0;
    }
    .proxima-fecha .pf-day  { font-size:17px; }
    .proxima-fecha .pf-mon  { font-size:9.5px; text-transform:uppercase; }
</style>
@endpush

@section('content')

<div class="row g-3 mb-3">
    <div class="col-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="kpi-val">{{ $totalClientes }}</div>
                <div class="kpi-lbl">Clientes</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-calendar3"></i></div>
            <div>
                <div class="kpi-val">{{ $totalCitas }}</div>
                <div class="kpi-lbl">Citas totales</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-scissors"></i></div>
            <div>
                <div class="kpi-val">{{ $totalPeluqueros }}</div>
                <div class="kpi-lbl">Peluqueros activos</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="bi bi-clipboard-check"></i></div>
            <div>
                <div class="kpi-val">{{ $totalServicios }}</div>
                <div class="kpi-lbl">Servicios activos</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12">
        <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#9CA3AF;margin-bottom:10px;">
            Hoy · {{ now()->format('d/m/Y') }}
        </div>
    </div>
    <div class="col-6">
        <div class="status-card">
            <div class="status-dot dot-confirmed"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="status-val">{{ $confirmadasHoy }}</div>
                <div class="status-lbl">Confirmadas</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="status-card">
            <div class="status-dot dot-cancelled"><i class="bi bi-x-circle"></i></div>
            <div>
                <div class="status-val">{{ $canceladasHoy }}</div>
                <div class="status-lbl">Canceladas</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-7">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="bi bi-bar-chart" style="color:#111111;"></i> Últimas 6 semanas</div>
            </div>
            <div class="panel-body pt-3">
                <canvas id="chartSemanas" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="bi bi-calendar-week" style="color:#111111;"></i> Esta semana</div>
            </div>
            <div class="panel-body pt-3">
                <canvas id="chartSemanaActual" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="bi bi-list-ul" style="color:#111111;"></i> Citas de hoy</div>
                <a href="{{ route('admin.citas.index', ['fecha' => today()->toDateString()]) }}"
                   style="font-size:12.5px;color:#111111;font-weight:600;text-decoration:none;">
                    Ver todas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @if($citasHoy->isEmpty())
                <div class="panel-body pt-4 pb-2 text-center" style="color:#9CA3AF;font-size:14px;">
                    <i class="bi bi-calendar-x d-block mb-2" style="font-size:32px;"></i>
                    No hay citas para hoy
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="sb-table">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Peluquero</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citasHoy as $cita)
                            <tr>
                                <td style="font-weight:700;color:#111;">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                <td>
                                    <div style="font-weight:600;color:#111;">{{ $cita->usuario->nombre }} {{ $cita->usuario->apellidos }}</div>
                                    <div style="font-size:12px;color:#9CA3AF;">{{ $cita->usuario->email }}</div>
                                </td>
                                <td>{{ $cita->peluquero->nombre }}</td>
                                <td>{{ $cita->servicio->nombre }}</td>
                                <td>
                                    @if($cita->estado === 'CONFIRMADA')
                                        <span class="sb-badge sb-badge-c">Confirmada</span>
                                    @else
                                        <span class="sb-badge sb-badge-x">Cancelada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.citas.show', $cita->id_cita) }}" style="font-size:13px;color:#111111;font-weight:600;text-decoration:none;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="col-xl-4 d-flex flex-column gap-3">
        <div class="panel flex-shrink-0">
            <div class="panel-head">
                <div class="panel-title"><i class="bi bi-calendar-event" style="color:#111111;"></i> Próximas citas</div>
            </div>
            <div class="panel-body">
                @if($proximasCitas->isEmpty())
                    <p style="font-size:13.5px;color:#9CA3AF;text-align:center;padding:16px 0 0;">Sin próximas citas</p>
                @else
                    @foreach($proximasCitas as $cita)
                    <div class="proxima-item">
                        <div class="proxima-fecha">
                            <span class="pf-day">{{ $cita->fecha->format('d') }}</span>
                            <span class="pf-mon">{{ $cita->fecha->format('m') }}</span>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:600;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $cita->usuario->nombre }} {{ $cita->usuario->apellidos }}
                            </div>
                            <div style="font-size:12px;color:#6B7280;">
                                {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }} · {{ $cita->peluquero->nombre }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gold    = '#111111';
    const goldBg  = 'rgba(0,0,0,.06)';

    new Chart(document.getElementById('chartSemanas'), {
        type: 'line',
        data: {
            labels: @json($etiquetasSemanas),
            datasets: [{
                label: 'Citas',
                data: @json($citasPorSemana),
                borderColor: gold,
                backgroundColor: goldBg,
                fill: true,
                tension: .35,
                pointBackgroundColor: gold,
                pointRadius: 4,
                borderWidth: 2.5,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { size: 12 } }, grid: { color: '#F3F4F6' } },
                x: { ticks: { font: { size: 12 } }, grid: { display: false } },
            }
        }
    });

    new Chart(document.getElementById('chartSemanaActual'), {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            datasets: [{
                label: 'Citas',
                data: @json($citasSemanaActual),
                backgroundColor: gold,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { size: 12 } }, grid: { color: '#F3F4F6' } },
                x: { ticks: { font: { size: 12 } }, grid: { display: false } },
            }
        }
    });
});
</script>
@endpush
