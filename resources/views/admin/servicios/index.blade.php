@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Gestión de servicios')

@push('styles')
<style>
    .sb-table { width:100%; border-collapse:collapse; font-size:13.5px; }
    .sb-table th { padding:10px 14px; font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#9CA3AF; background:#FAFAFA; border-bottom:1px solid #F3F4F6; white-space:nowrap; }
    .sb-table td { padding:10px 14px; border-bottom:1px solid #F9FAFB; color:#374151; vertical-align:middle; }
    .sb-table tr:last-child td { border-bottom:none; }
    .sb-table tbody tr:hover td { background:#FAFAFA; }

    .sb-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; }
    .sb-badge-on  { background:#DCFCE7; color:#166534; }
    .sb-badge-off { background:#F3F4F6; color:#6B7280; }

    .action-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:30px; height:30px; border-radius:7px; border:none;
        font-size:14px; cursor:pointer; text-decoration:none; transition:background .15s;
    }
    .action-btn-edit { background:#EFF6FF; color:#2563EB; }
    .action-btn-edit:hover { background:#DBEAFE; color:#1D4ED8; }
    .action-btn-del  { background:#FEE2E2; color:#DC2626; }
    .action-btn-del:hover  { background:#FECACA; color:#991B1B; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div style="font-size:13px;color:#6B7280;">
        {{ $servicios->count() }} {{ Str::plural('servicio', $servicios->count()) }} registrado{{ $servicios->count() !== 1 ? 's' : '' }}
    </div>
    <a href="{{ route('admin.servicios.crear') }}" class="btn-sb">
        <i class="bi bi-plus-lg me-1"></i> Nuevo servicio
    </a>
</div>

<div class="card" style="border-radius:var(--sb-radius);">
    @if($servicios->isEmpty())
        <div class="text-center py-5" style="color:#9CA3AF;">
            <i class="bi bi-clipboard-x d-block mb-2" style="font-size:36px;"></i>
            <p class="mb-0" style="font-size:14px;">No hay servicios registrados.</p>
            <a href="{{ route('admin.servicios.crear') }}" class="btn-sb mt-3 d-inline-flex">
                <i class="bi bi-plus-lg me-1"></i> Crear el primero
            </a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="sb-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                    <tr>
                        <td style="color:#9CA3AF;font-size:12px;">{{ $servicio->id_servicio }}</td>
                        <td style="font-weight:700;color:#111;">{{ $servicio->nombre }}</td>
                        <td style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#6B7280;font-size:13px;">
                            {{ $servicio->descripcion ?? '—' }}
                        </td>
                        <td style="font-weight:600;color:#111;white-space:nowrap;">
                            {{ number_format($servicio->precio, 2, ',', '.') }} €
                        </td>
                        <td style="white-space:nowrap;">{{ $servicio->duracion }} min</td>
                        <td>
                            @if($servicio->activo)
                                <span class="sb-badge sb-badge-on"><i class="bi bi-check-circle me-1"></i> Activo</span>
                            @else
                                <span class="sb-badge sb-badge-off"><i class="bi bi-pause-circle me-1"></i> Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.servicios.editar', $servicio->id_servicio) }}" class="action-btn action-btn-edit" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.servicios.eliminar', $servicio->id_servicio) }}" onsubmit="return false;">
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
    @endif
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-del').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const form = btn.closest('form');
        Swal.fire({
            title: '¿Eliminar este servicio?',
            text: 'Si tiene citas asociadas no podrá eliminarse.',
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
