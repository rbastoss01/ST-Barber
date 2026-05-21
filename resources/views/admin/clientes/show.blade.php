@extends('layouts.admin')

@section('title', $cliente->nombre . ' ' . $cliente->apellidos)
@section('page-title', 'Perfil de cliente')

@push('styles')
<style>
    .profile-card {
        background:#fff; border:1px solid var(--sb-border);
        border-radius:var(--sb-radius); padding:24px;
    }
    .profile-avatar {
        width:64px; height:64px; border-radius:50%;
        background:var(--sb-gold-light); color:var(--sb-gold);
        font-size:24px; font-weight:800;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .info-row { display:flex; flex-direction:column; gap:2px; }
    .info-lbl { font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#9CA3AF; }
    .info-val { font-size:14px; font-weight:600; color:#111; }

    .sb-table { width:100%; border-collapse:collapse; font-size:13.5px; }
    .sb-table th { padding:10px 14px; font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#9CA3AF; background:#FAFAFA; border-bottom:1px solid #F3F4F6; white-space:nowrap; }
    .sb-table td { padding:10px 14px; border-bottom:1px solid #F9FAFB; color:#374151; vertical-align:middle; }
    .sb-table tr:last-child td { border-bottom:none; }
    .sb-table tbody tr:hover td { background:#FAFAFA; }

    .sb-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; }
    .sb-badge-c { background:#DCFCE7; color:#166534; }
    .sb-badge-x { background:#FEE2E2; color:#991B1B; }
    .sb-badge-on  { background:#DCFCE7; color:#166534; }
    .sb-badge-off { background:#F3F4F6; color:#6B7280; }

    .stat-box {
        background:#FAFAFA; border:1px solid var(--sb-border);
        border-radius:var(--sb-radius-sm);
        padding:14px 18px; text-align:center;
    }
    .stat-val { font-size:22px; font-weight:800; color:#111; line-height:1; }
    .stat-lbl { font-size:11.5px; color:#6B7280; font-weight:500; margin-top:4px; }
</style>
@endpush

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.clientes.index') }}"
       style="font-size:13px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
        <i class="bi bi-arrow-left"></i> Volver a clientes
    </a>
</div>

<div class="row g-3 mb-3">

    <div class="col-lg-4">
        <div class="profile-card h-100">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="profile-avatar">
                    {{ strtoupper(substr($cliente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:17px;font-weight:800;color:#111;">{{ $cliente->nombre }} {{ $cliente->apellidos }}</div>
                    <div style="font-size:12.5px;color:var(--sb-gold);font-weight:600;">Cliente</div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="info-row">
                    <span class="info-lbl"><i class="bi bi-envelope me-1"></i>Email</span>
                    <span class="info-val" style="word-break:break-all;">{{ $cliente->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl"><i class="bi bi-telephone me-1"></i>Teléfono</span>
                    <span class="info-val">{{ $cliente->telefono ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl"><i class="bi bi-calendar me-1"></i>Registrado</span>
                    <span class="info-val">{{ $cliente->fecha_registro?->translatedFormat('d \d\e F \d\e Y') ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl"><i class="bi bi-circle me-1"></i>Estado</span>
                    <span>
                        @if($cliente->activo)
                            <span class="sb-badge sb-badge-on">Activo</span>
                        @else
                            <span class="sb-badge sb-badge-off">Inactivo</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="mt-4 pt-3" style="border-top:1px solid #F3F4F6;">
                <form method="POST" action="{{ route('admin.clientes.eliminar', $cliente->id) }}"
                      id="formEliminar" onsubmit="return false;">
                    @csrf @method('DELETE')
                    <button type="button" id="btnEliminar"
                            class="d-inline-flex align-items-center gap-2 border-0 bg-transparent p-0"
                            style="font-size:13px;color:#DC2626;font-weight:600;cursor:pointer;">
                        <i class="bi bi-trash3"></i> Eliminar cliente
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8 d-flex flex-column gap-3">

        <div class="row g-2">
            @php
                $total      = $citas->count();
                $confirmadas= $citas->where('estado', 'CONFIRMADA')->count();
                $canceladas = $citas->where('estado', 'CANCELADA')->count();
            @endphp
            <div class="col-4">
                <div class="stat-box">
                    <div class="stat-val">{{ $total }}</div>
                    <div class="stat-lbl">Total</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-box">
                    <div class="stat-val" style="color:#16A34A;">{{ $confirmadas }}</div>
                    <div class="stat-lbl">Confirmadas</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-box">
                    <div class="stat-val" style="color:#DC2626;">{{ $canceladas }}</div>
                    <div class="stat-lbl">Canceladas</div>
                </div>
            </div>
        </div>

        <div class="card" style="border-radius:var(--sb-radius);flex:1;">
            <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;">
                <span style="font-size:14px;font-weight:700;color:#111;">
                    <i class="bi bi-calendar3 me-2" style="color:var(--sb-gold);"></i>Historial de citas
                </span>
            </div>

            @if($citas->isEmpty())
                <div class="text-center py-5" style="color:#9CA3AF;">
                    <i class="bi bi-calendar-x d-block mb-2" style="font-size:32px;"></i>
                    <p class="mb-0" style="font-size:14px;">Este cliente no tiene citas registradas.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="sb-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Peluquero</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                            <tr>
                                <td style="font-weight:600;color:#111;white-space:nowrap;">
                                    @php $f = \Carbon\Carbon::parse($cita->fecha); @endphp
                                    {{ $f->format('d') }} {{ ucfirst(rtrim($f->translatedFormat('M'), '.')) }} {{ $f->format('Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                <td>{{ $cita->peluquero->nombre }}</td>
                                <td style="max-width:130px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $cita->servicio->nombre }}
                                </td>
                                <td>
                                    @if($cita->estado === 'CONFIRMADA')
                                        <span class="sb-badge sb-badge-c">Confirmada</span>
                                    @else
                                        <span class="sb-badge sb-badge-x">Cancelada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.citas.show', $cita->id_cita) }}"
                                       style="font-size:13px;color:var(--sb-gold);font-weight:600;text-decoration:none;">
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
</div>

@endsection

@push('scripts')
<script>
document.getElementById('btnEliminar')?.addEventListener('click', function () {
    Swal.fire({
        title: '¿Eliminar este cliente?',
        text: 'Si tiene citas asociadas no podrá eliminarse.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(function (result) {
        if (result.isConfirmed) document.getElementById('formEliminar').submit();
    });
});
</script>
@endpush
