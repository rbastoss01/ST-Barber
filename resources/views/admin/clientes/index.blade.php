@extends('layouts.admin')

@section('title', 'Clientes')
@section('page-title', 'Gestión de clientes')

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

    .filter-bar { background:#fff; border:1px solid var(--sb-border); border-radius:var(--sb-radius); padding:16px 20px; margin-bottom:20px; }

    .action-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:30px; height:30px; border-radius:7px; border:none;
        font-size:14px; cursor:pointer; text-decoration:none; transition:background .15s;
    }
    .action-btn-view { background:#F3F4F6; color:#374151; }
    .action-btn-view:hover { background:#E5E7EB; color:#111; }
    .action-btn-del  { background:#FEE2E2; color:#DC2626; }
    .action-btn-del:hover  { background:#FECACA; color:#991B1B; }

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

<div class="filter-bar">
    <form method="GET" action="{{ route('admin.clientes.index') }}" class="row g-2 align-items-end">
        <div class="col-sm-8 col-md-6 col-lg-5">
            <label class="form-label" style="font-size:12px;font-weight:600;color:#374151;">Buscar cliente</label>
            <input type="text" name="buscar" class="form-control form-control-sm"
                   placeholder="Nombre, apellidos o email…" value="{{ request('buscar') }}">
        </div>
        <div class="col-sm-4 col-md-3 col-lg-2 d-flex gap-2">
            <button type="submit" class="btn-sb flex-fill" style="justify-content:center;">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
            @if(request('buscar'))
                <a href="{{ route('admin.clientes.index') }}" class="d-inline-flex align-items-center justify-content-center px-3 py-1 border rounded" style="font-size:13px;color:#6B7280;text-decoration:none;border-radius:8px!important;">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card" style="border-radius:var(--sb-radius);">
    <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;">
        <span style="font-size:14px;font-weight:700;color:#111;">
            {{ $clientes->total() }} {{ Str::plural('cliente', $clientes->total()) }} encontrado{{ $clientes->total() !== 1 ? 's' : '' }}
        </span>
    </div>

    @if($clientes->isEmpty())
        <div class="text-center py-5" style="color:#9CA3AF;">
            <i class="bi bi-people d-block mb-2" style="font-size:36px;"></i>
            <p class="mb-0" style="font-size:14px;">No se encontraron clientes.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="sb-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Registrado</th>
                        <th>Citas</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td style="color:#9CA3AF;font-size:12px;">{{ $cliente->id }}</td>
                        <td>
                            <div style="font-weight:700;color:#111;">{{ $cliente->nombre }} {{ $cliente->apellidos }}</div>
                            <div style="font-size:11.5px;color:#9CA3AF;">{{ $cliente->email }}</div>
                        </td>
                        <td style="color:#6B7280;font-size:13px;">{{ $cliente->telefono ?? '—' }}</td>
                        <td style="font-size:13px;white-space:nowrap;">
                            {{ $cliente->fecha_registro?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td>
                            <span style="font-weight:600;color:#111;">{{ $cliente->citas_count }}</span>
                        </td>
                        <td>
                            @if($cliente->activo)
                                <span class="sb-badge sb-badge-on">Activo</span>
                            @else
                                <span class="sb-badge sb-badge-off">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.clientes.show', $cliente->id) }}" class="action-btn action-btn-view" title="Ver perfil">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.clientes.eliminar', $cliente->id) }}" onsubmit="return false;">
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

        @if($clientes->hasPages())
            <div style="padding:14px 20px;border-top:1px solid #F3F4F6;">
                {{ $clientes->links() }}
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
            title: '¿Eliminar este cliente?',
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
