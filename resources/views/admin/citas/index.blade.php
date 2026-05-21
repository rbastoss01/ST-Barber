@extends('layouts.admin')

@section('title', 'Citas')
@section('page-title', 'Gestión de citas')

@push('styles')
<style>
    .sb-table { width:100%; border-collapse:collapse; font-size:13.5px; }
    .sb-table th { padding:10px 14px; font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#9CA3AF; background:#FAFAFA; border-bottom:1px solid #F3F4F6; white-space:nowrap; }
    .sb-table td { padding:10px 14px; border-bottom:1px solid #F9FAFB; color:#374151; vertical-align:middle; }
    .sb-table tr:last-child td { border-bottom:none; }
    .sb-table tbody tr:hover td { background:#FAFAFA; }

    .sb-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; }
    .sb-badge-p { background:#FEF3C7; color:#92400E; }
    .sb-badge-c { background:#DCFCE7; color:#166534; }
    .sb-badge-x { background:#FEE2E2; color:#991B1B; }

    .filter-bar { background:#fff; border:1px solid var(--sb-border); border-radius:var(--sb-radius); padding:16px 20px; margin-bottom:20px; }
    .action-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:30px; height:30px; border-radius:7px; border:none;
        font-size:14px; cursor:pointer; text-decoration:none; transition:background .15s;
    }
    .action-btn-view  { background:#F3F4F6; color:#374151; }
    .action-btn-view:hover  { background:#E5E7EB; color:#111; }
    .action-btn-del   { background:#FEE2E2; color:#DC2626; }
    .action-btn-del:hover   { background:#FECACA; color:#991B1B; }
</style>
@endpush

@section('content')

<div class="filter-bar">
    <form method="GET" action="{{ route('admin.citas.index') }}" class="row g-2 align-items-end">
        <div class="col-sm-6 col-md-3 col-lg-2">
            <label class="form-label" style="font-size:12px;font-weight:600;color:#374151;">Fecha</label>
            <input type="date" name="fecha" class="form-control form-control-sm" value="{{ request('fecha') }}">
        </div>
        <div class="col-sm-6 col-md-3 col-lg-2">
            <label class="form-label" style="font-size:12px;font-weight:600;color:#374151;">Estado</label>
            <select name="estado" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="CONFIRMADA" @selected(request('estado') === 'CONFIRMADA')>Confirmada</option>
                <option value="CANCELADA"  @selected(request('estado') === 'CANCELADA')>Cancelada</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <label class="form-label" style="font-size:12px;font-weight:600;color:#374151;">Peluquero</label>
            <select name="peluquero" class="form-select form-select-sm">
                <option value="">Todos</option>
                @foreach($peluqueros as $p)
                    <option value="{{ $p->id_peluquero }}" @selected(request('peluquero') == $p->id_peluquero)>
                        {{ $p->nombre }} {{ $p->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3">
            <label class="form-label" style="font-size:12px;font-weight:600;color:#374151;">Cliente</label>
            <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nombre o email…" value="{{ request('buscar') }}">
        </div>
        <div class="col-lg-2 d-flex gap-2">
            <button type="submit" class="btn-sb flex-fill" style="justify-content:center;">
                <i class="bi bi-search me-1"></i> Filtrar
            </button>
            @if(request()->hasAny(['fecha','estado','peluquero','buscar']))
                <a href="{{ route('admin.citas.index') }}" class="d-inline-flex align-items-center justify-content-center px-3 py-1 border rounded" style="font-size:13px;color:#6B7280;text-decoration:none;border-radius:8px!important;">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card" style="border-radius:var(--sb-radius);">
    <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:14px;font-weight:700;color:#111;">
            {{ $citas->total() }} {{ Str::plural('cita', $citas->total()) }} encontrada{{ $citas->total() !== 1 ? 's' : '' }}
        </span>
    </div>

    @if($citas->isEmpty())
        <div class="text-center py-5" style="color:#9CA3AF;">
            <i class="bi bi-calendar-x d-block mb-2" style="font-size:36px;"></i>
            <p class="mb-0" style="font-size:14px;">No se encontraron citas con esos filtros.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="sb-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Peluquero</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                    <tr>
                        <td style="color:#9CA3AF;font-size:12px;">{{ $cita->id_cita }}</td>
                        <td style="font-weight:600;color:#111;white-space:nowrap;">
                            {{ $cita->fecha->format('d') }} {{ ucfirst(rtrim($cita->fecha->translatedFormat('M'), '.')) }} {{ $cita->fecha->format('Y') }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                        <td>
                            <div style="font-weight:600;color:#111;">{{ $cita->usuario->nombre }} {{ $cita->usuario->apellidos }}</div>
                            <div style="font-size:11.5px;color:#9CA3AF;">{{ $cita->usuario->email }}</div>
                        </td>
                        <td>{{ $cita->peluquero->nombre }}</td>
                        <td style="max-width:130px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $cita->servicio->nombre }}</td>
                        <td>
                            @if($cita->estado === 'CONFIRMADA')
                                <span class="sb-badge sb-badge-c">Confirmada</span>
                            @else
                                <span class="sb-badge sb-badge-x">Cancelada</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.citas.show', $cita->id_cita) }}"
                                   class="action-btn action-btn-view" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.citas.eliminar', $cita->id_cita) }}"
                                      class="form-del-cita" onsubmit="return false;">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn action-btn-del btn-del" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($citas->hasPages())
            <div style="padding:14px 20px;border-top:1px solid #F3F4F6;">
                {{ $citas->links() }}
            </div>
        @endif
    @endif
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-del').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const form = btn.closest('form');
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
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
