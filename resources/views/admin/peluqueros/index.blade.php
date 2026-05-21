@extends('layouts.admin')

@section('title', 'Peluqueros')
@section('page-title', 'Gestión de peluqueros')

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
    .action-btn-edit    { background:#EFF6FF; color:#2563EB; }
    .action-btn-edit:hover    { background:#DBEAFE; color:#1D4ED8; }
    .action-btn-del     { background:#FEE2E2; color:#DC2626; }
    .action-btn-del:hover     { background:#FECACA; color:#991B1B; }
    .action-btn-ausente { background:#FEF3C7; color:#D97706; }
    .action-btn-ausente:hover { background:#FDE68A; color:#92400E; }
    .action-btn-presente{ background:#DCFCE7; color:#16A34A; }
    .action-btn-presente:hover{ background:#BBF7D0; color:#166534; }

    .sb-badge-aus { background:#FEF3C7; color:#92400E; }

    .avatar-circle {
        width:36px; height:36px; border-radius:50%;
        background:var(--sb-gold-light); color:var(--sb-gold);
        font-weight:700; font-size:14px;
        display:inline-flex; align-items:center; justify-content:center;
        flex-shrink:0;
    }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div style="font-size:13px;color:#6B7280;">
        {{ $peluqueros->count() }} {{ Str::plural('peluquero', $peluqueros->count()) }} registrado{{ $peluqueros->count() !== 1 ? 's' : '' }}
    </div>
    <a href="{{ route('admin.peluqueros.crear') }}" class="btn-sb">
        <i class="bi bi-plus-lg me-1"></i> Nuevo peluquero
    </a>
</div>

<div class="card" style="border-radius:var(--sb-radius);">
    @if($peluqueros->isEmpty())
        <div class="text-center py-5" style="color:#9CA3AF;">
            <i class="bi bi-scissors d-block mb-2" style="font-size:36px;"></i>
            <p class="mb-0" style="font-size:14px;">No hay peluqueros registrados.</p>
            <a href="{{ route('admin.peluqueros.crear') }}" class="btn-sb mt-3 d-inline-flex">
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
                        <th>Especialidad</th>
                        <th>Citas totales</th>
                        <th>Estado</th>
                        <th>Disponibilidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peluqueros as $peluquero)
                    <tr>
                        <td style="color:#9CA3AF;font-size:12px;">{{ $peluquero->id_peluquero }}</td>
                        <td>
                            <div style="font-weight:700;color:#111;">{{ $peluquero->nombre }} {{ $peluquero->apellidos }}</div>
                        </td>
                        <td style="color:#6B7280;font-size:13px;">{{ $peluquero->especialidad ?? '—' }}</td>
                        <td>
                            <span style="font-weight:600;color:#111;">{{ $peluquero->citas_count }}</span>
                            <span style="font-size:12px;color:#9CA3AF;"> citas</span>
                        </td>
                        <td>
                            @if($peluquero->activo)
                                <span class="sb-badge sb-badge-on"><i class="bi bi-check-circle me-1"></i> Activo</span>
                            @else
                                <span class="sb-badge sb-badge-off"><i class="bi bi-pause-circle me-1"></i> Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @if($peluquero->ausente)
                                <span class="sb-badge sb-badge-aus"><i class="bi bi-moon me-1"></i> Ausente</span>
                            @else
                                <span class="sb-badge sb-badge-on"><i class="bi bi-person-check me-1"></i> Disponible</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <form method="POST"
                                      action="{{ route('admin.peluqueros.ausencia', $peluquero->id_peluquero) }}">
                                    @csrf @method('PUT')
                                    @if($peluquero->ausente)
                                        <button type="submit"class="action-btn action-btn-presente" title="Marcar disponible">
                                            <i class="bi bi-person-check"></i>
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="action-btn action-btn-ausente"
                                                title="Marcar ausente">
                                            <i class="bi bi-moon"></i>
                                        </button>
                                    @endif
                                </form>
                                <a href="{{ route('admin.peluqueros.editar', $peluquero->id_peluquero) }}" class="action-btn action-btn-edit" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.peluqueros.eliminar', $peluquero->id_peluquero) }}" onsubmit="return false;">
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
            title: '¿Eliminar este peluquero?',
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
