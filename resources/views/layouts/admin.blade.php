<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · ST BARBER</title>
    <link rel="icon" type="image/jpeg" href="/images/logo.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sb-sidebar-bg:  #111111;
            --sb-sidebar-w:   260px;
            --sb-topbar-h:    62px;
            --sb-body:        #F4F5F7;
            --sb-border:      #E9ECEF;
            --sb-radius:      12px;
            --sb-radius-sm:   8px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--sb-body);
            color: #212529;
            margin: 0;
        }

        .sb-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sb-sidebar-w);
            height: 100vh;
            background: var(--sb-sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        @media (max-width: 991.98px) {
            .sb-sidebar {
                transform: translateX(-100%);
            }
            .sb-sidebar.open {
                transform: translateX(0);
                box-shadow: 8px 0 32px rgba(0,0,0,.35);
            }
        }

        .sb-sidebar-brand {
            padding: 22px 24px 18px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }

        .sb-sidebar-brand-text {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 5px;
            color: #fff;
            text-transform: uppercase;
            text-decoration: none;
        }

        .sb-sidebar-brand-sub {
            font-size: 10px;
            color: rgba(255,255,255,.4);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sb-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .sb-nav-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            padding: 0 12px;
            margin: 8px 0 4px;
        }

        .sb-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--sb-radius-sm);
            text-decoration: none;
            color: rgba(255,255,255,.55);
            font-size: 13.5px;
            font-weight: 500;
            transition: color .2s, background .2s;
            margin-bottom: 2px;
            white-space: nowrap;
        }

        .sb-nav-link i {
            font-size: 16px;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }

        .sb-nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.06);
        }

        .sb-nav-link.active {
            color: #111111;
            background: #ffffff;
            font-weight: 600;
        }

        .sb-nav-link.active i { color: #111111; }

        .sb-sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }

        .sb-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--sb-radius-sm);
            margin-bottom: 4px;
        }

        .sb-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sb-user-role {
            font-size: 10.5px;
            color: rgba(255,255,255,.4);
            font-weight: 500;
        }

        .sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 199;
        }

        .sb-overlay.show { display: block; }

        .sb-topbar {
            height: var(--sb-topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--sb-border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .sb-topbar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: none;
            background: #F3F4F6;
            border-radius: var(--sb-radius-sm);
            color: #374151;
            font-size: 18px;
            cursor: pointer;
            transition: background .2s;
            flex-shrink: 0;
        }

        .sb-topbar-toggle:hover { background: #E5E7EB; }

        @media (max-width: 991.98px) {
            .sb-topbar-toggle { display: flex; }
        }

        .sb-topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: #111;
            flex: 1;
        }

        .sb-main-wrapper {
            margin-left: var(--sb-sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 991.98px) {
            .sb-main-wrapper { margin-left: 0; }
        }

        .sb-content {
            padding: 28px 28px 48px;
            flex: 1;
        }

        @media (max-width: 575.98px) {
            .sb-content { padding: 20px 16px 40px; }
        }

        .card {
            border: 1px solid var(--sb-border);
            border-radius: var(--sb-radius);
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        .form-control, .form-select {
            border-radius: var(--sb-radius-sm);
            border-color: var(--sb-border);
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #111111;
            box-shadow: 0 0 0 3px rgba(0,0,0,.08);
        }

        .btn-sb {
            background: #111111;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            border-radius: var(--sb-radius-sm);
            padding: 8px 20px;
            display: inline-flex;
            align-items: center;
            transition: background .2s;
            cursor: pointer;
        }

        .btn-sb:hover { background: #333333; color: #fff; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="sb-overlay" id="sbOverlay"></div>
    <aside class="sb-sidebar" id="sbSidebar">
        <div class="sb-sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="sb-sidebar-brand-text d-block">
                ST BARBER
            </a>
            <div class="sb-sidebar-brand-sub">Panel de administración</div>
        </div>
        <nav class="sb-nav">
            <div class="sb-nav-label">Principal</div>

            <a href="{{ route('admin.dashboard') }}" class="sb-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.citas.index') }}" class="sb-nav-link {{ request()->routeIs('admin.citas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Citas</span>
            </a>

            <div class="sb-nav-label mt-3">Gestión</div>

            <a href="{{ route('admin.clientes.index') }}" class="sb-nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Clientes</span>
            </a>

            <a href="{{ route('admin.peluqueros.index') }}" class="sb-nav-link {{ request()->routeIs('admin.peluqueros.*') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i>
                <span>Peluqueros</span>
            </a>

            <a href="{{ route('admin.servicios.index') }}" class="sb-nav-link {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                <span>Servicios</span>
            </a>

            <a href="{{ route('admin.horarios.index') }}" class="sb-nav-link {{ request()->routeIs('admin.horarios.*') ? 'active' : '' }}">
                <i class="bi bi-clock"></i>
                <span>Horarios</span>
            </a>
        </nav>
        <div class="sb-sidebar-footer">
            <div class="sb-user-info">
                <div class="sb-user-avatar">
                    {{ strtoupper(substr(auth()->user()->nombre ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="sb-user-name">
                        {{ auth()->user()->nombre ?? 'Administrador' }}
                    </div>
                    <div class="sb-user-role">Administrador</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-nav-link w-100 border-0 text-start" tyle="cursor:pointer;background:transparent;">
                    <i class="bi bi-box-arrow-left" style="color:rgba(255,255,255,.4);"></i>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>
    <div class="sb-main-wrapper">
        <header class="sb-topbar">
            <button class="sb-topbar-toggle" id="sbToggle" aria-label="Abrir menú">
                <i class="bi bi-list"></i>
            </button>

            <div class="sb-topbar-title">
                @yield('page-title', 'Panel de administración')
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('inicio') }}" target="_blank" style="font-size:12.5px;font-weight:500;color:#6B7280;">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Ver web</span>
                </a>
                <div class="dropdown">
                    <button class="d-flex align-items-center gap-2 border-0 bg-transparent p-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="sb-user-avatar" style="width:34px;height:34px;font-size:13px;background:#111111;color:#fff;">
                            {{ strtoupper(substr(auth()->user()->nombre ?? 'A', 0, 1)) }}
                        </div>
                        <i class="bi bi-chevron-down" style="font-size:11px;color:#6B7280;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:180px;border-radius:12px;padding:6px;border:1px solid #E9ECEF;box-shadow:0 8px 24px rgba(0,0,0,.08);">
                        <li class="px-3 py-2" style="border-bottom:1px solid #F3F4F6;margin-bottom:4px;">
                            <div style="font-size:13px;font-weight:600;color:#111;">
                                {{ auth()->user()->nombre ?? 'Administrador' }}
                            </div>
                            <div style="font-size:11.5px;color:#6B7280;">Administrador</div>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="border-radius:8px;padding:8px 14px;font-size:13.5px;font-weight:500;">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show m-0 rounded-0 border-0" style="font-size:14px;padding:12px 24px;" role="alert">
                <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="sb-content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function () {
            const toggle  = document.getElementById('sbToggle');
            const sidebar = document.getElementById('sbSidebar');
            const overlay = document.getElementById('sbOverlay');

            function openSidebar()  { sidebar.classList.add('open');  overlay.classList.add('show'); }
            function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('show'); }

            toggle?.addEventListener('click', function () {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            overlay?.addEventListener('click', closeSidebar);
        })();
    </script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                text: @json(session('success')),
                timer: 3500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true,
            });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Ha ocurrido un error',
                text: @json(session('error')),
                confirmButtonColor: '#111111',
                confirmButtonText: 'Entendido',
            });
        });
    </script>
    @endif
    @if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: @json(session('warning')),
                confirmButtonColor: '#111111',
                confirmButtonText: 'Entendido',
            });
        });
    </script>
    @endif
    @stack('scripts')
</body>
</html>
