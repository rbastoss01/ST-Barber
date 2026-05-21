<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ST BARBER')</title>
    <link rel="icon" type="image/jpeg" href="/images/logo.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sb-dark:       #111111;
            --sb-body:       #F5F5F5;
            --sb-border:     #E9ECEF;
            --sb-radius:     12px;
            --sb-radius-sm:  8px;
        }

        html { margin: 0; padding: 0; height: 100%; }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--sb-body);
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main { flex: 1; padding-top: 104px; }

        .sb-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--sb-border);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            min-height: 104px;
            padding-top: 22px;
            padding-bottom: 22px;
        }

        .sb-navbar .navbar-brand {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 6px;
            color: var(--sb-dark);
            text-transform: uppercase;
        }

        .sb-navbar .nav-link {
            font-size: 14.5px;
            font-weight: 500;
            color: #555;
            padding: 9px 16px;
            border-radius: var(--sb-radius-sm);
            transition: color .2s, background .2s;
        }

        .sb-navbar .nav-link:hover,
        .sb-navbar .nav-link.active {
            color: var(--sb-dark);
            background: #F3F4F6;
        }

        .btn-sb {
            background: #111111;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            border-radius: var(--sb-radius-sm);
            padding: 8px 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: background .2s, transform .1s;
            letter-spacing: .3px;
            cursor: pointer;
        }

        .btn-sb:hover {
            background: #333333;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-outline-sb {
            background: transparent;
            border: 1.5px solid var(--sb-dark);
            color: var(--sb-dark);
            font-weight: 600;
            font-size: 13px;
            border-radius: var(--sb-radius-sm);
            padding: 7px 20px;
            display: inline-flex;
            align-items: center;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-outline-sb:hover {
            background: var(--sb-dark);
            color: #fff;
        }

        .dropdown-menu {
            border: 1px solid var(--sb-border);
            border-radius: var(--sb-radius);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            padding: 6px;
            min-width: 180px;
        }

        .dropdown-item {
            border-radius: var(--sb-radius-sm);
            padding: 8px 14px;
            font-size: 13.5px;
            font-weight: 500;
            color: #374151;
            transition: background .15s;
        }

        .dropdown-item:hover { background: #F3F4F6; color: #111; }
        .dropdown-item.text-danger:hover { background: #FEF2F2; color: #dc3545; }

        .sb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #111111;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb-footer {
            background: #0a0a0a;
            color: rgba(255,255,255,.45);
            padding: 72px 0 0;
            margin-top: 80px;
            font-size: 13px;
        }

        .sb-footer-brand-col {
            padding-right: 8px;
        }

        .sb-footer-brand-st,
        .sb-footer-brand-barber {
            display: block;
            font-size: clamp(44px, 6.5vw, 72px);
            font-weight: 800;
            color: #fff;
            line-height: 0.9;
            text-transform: uppercase;
            letter-spacing: -1.5px;
        }

        .sb-footer-tagline {
            font-size: 13px;
            color: rgba(255,255,255,.28);
            margin-top: 18px;
            font-weight: 400;
            letter-spacing: .3px;
            line-height: 1.65;
        }

        .sb-footer-col-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 22px;
        }

        .sb-footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .sb-footer-list li {
            color: rgba(255,255,255,.4);
            font-size: 14px;
        }

        .sb-footer-list a {
            color: rgba(255,255,255,.4);
            text-decoration: none;
            font-size: 14px;
            transition: color .2s;
        }

        .sb-footer-list a:hover { color: #fff; }

        .sb-footer-socials {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sb-social-btn {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(255,255,255,.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            transition: background .2s, color .2s;
            border: 1px solid rgba(255,255,255,.08);
        }

        .sb-social-btn:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .sb-footer-bottom {
            border-top: 1px solid rgba(255,255,255,.06);
            margin-top: 52px;
            padding: 22px 0;
            font-size: 12px;
            color: rgba(255,255,255,.2);
            text-align: center;
        }

        .sb-footer a {
            color: rgba(255,255,255,.4);
            text-decoration: none;
            transition: color .2s;
        }

        .sb-footer a:hover { color: #ffffff; }

        @media (max-width: 575.98px) {
            .modal-dialog {
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        @media (max-width: 991.98px) {
            .sb-navbar .navbar-brand {
                margin-left: 12px;
            }
            .sb-navbar .navbar-collapse {
                padding-top: 16px;
            }
            .sb-navbar .navbar-nav.ms-auto {
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid var(--sb-border);
            }
        }

        @media (max-width: 767.98px) {
            .sb-footer-mobile-hide { display: none !important; }

            .sb-footer-brand-col {
                text-align: center;
            }

            .sb-footer-brand-st,
            .sb-footer-brand-barber {
                font-size: 52px;
            }

            .sb-footer-tagline { display: none; }

            .sb-footer-socials {
                justify-content: center;
            }

            .sb-footer-col-title { display: none; }
            .sb-footer-socials + p { text-align: center; }
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
    </style>

    @stack('styles')
</head>
<body>
    <nav class="sb-navbar navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('inicio') }}">ST BARBER</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto ms-3 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('servicios') ? 'active' : '' }}" href="{{ route('servicios') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informacion') ? 'active' : '' }}" href="{{ route('informacion') }}">Información</a>
                    </li>
                    @auth
                        @if(auth()->user()->esCliente())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('citas.reservar') ? 'active' : '' }}" href="{{ route('citas.reservar') }}">Reservar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}" href="{{ route('citas.index') }}">Mis citas</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @guest
                        <li class="nav-item">
                            <button class="btn-outline-sb" data-bs-toggle="modal" data-bs-target="#modalLogin">
                                Iniciar sesión
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="btn-sb" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                                Reservar cita
                            </button>
                        </li>
                    @endguest
                    @auth
                        @if(auth()->user()->esAdmin())
                            <li class="nav-item">
                                <a class="btn-sb" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-grid-1x2 me-1"></i>Panel de administración
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="sb-avatar">
                                    {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                                </span>
                                <span style="font-size:13.5px;font-weight:500;color:#374151;">
                                    {{ auth()->user()->nombre }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->esCliente())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('perfil.index') }}">
                                            <i class="bi bi-person me-2 text-muted"></i>Mi perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('citas.index') }}">
                                            <i class="bi bi-calendar3 me-2 text-muted"></i>Mis citas
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show m-0 rounded-0 border-0" style="font-size:14px;padding:12px 0;" role="alert">
            <div class="container">
                <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <main>
        @yield('content')
    </main>
    <footer class="sb-footer">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start">
                <div class="col-12 col-md-3">
                    <div class="sb-footer-brand-col">
                        <span class="sb-footer-brand-st">ST</span>
                        <span class="sb-footer-brand-barber">BARBER</span>
                    </div>
                </div>
                <div class="col-6 col-md-3 sb-footer-mobile-hide">
                    <div class="sb-footer-col-title">Navegación</div>
                    <ul class="sb-footer-list">
                        <li><a href="{{ route('inicio') }}">Inicio</a></li>
                        <li><a href="{{ route('servicios') }}">Servicios</a></li>
                        <li><a href="{{ route('informacion') }}">Información</a></li>
                        @guest
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalRegistro">Reservar cita</a></li>
                        @endguest
                        @auth
                        @if(auth()->user()->esCliente())
                        <li><a href="{{ route('citas.reservar') }}">Reservar cita</a></li>
                        <li><a href="{{ route('citas.index') }}">Mis citas</a></li>
                        @endif
                        @endauth
                    </ul>
                </div>
                <div class="col-6 col-md-3 sb-footer-mobile-hide">
                    <div class="sb-footer-col-title">Contacto</div>
                    <ul class="sb-footer-list">
                        <li><i class="bi bi-geo-alt me-2"></i>Calle Medellín 11, Navalmoral de la Mata</li>
                        <li><a href="tel:+34927534821"><i class="bi bi-telephone me-2"></i>927 534 821</a></li>
                        <li><i class="bi bi-clock me-2"></i>Lun–Vie: 09:00–20:00</li>
                        <li><i class="bi bi-clock me-2"></i>Sábado: 09:00–14:00</li>
                        <li><a href="{{ route('informacion') }}"><i class="bi bi-envelope me-2"></i>Más información</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-3">
                    <div class="sb-footer-col-title">Síguenos</div>
                    <div class="sb-footer-socials">
                        <a href="https://instagram.com/stbarber" target="_blank" rel="noopener" class="sb-social-btn" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://facebook.com/stbarber" target="_blank" rel="noopener" class="sb-social-btn" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://tiktok.com/@stbarber" target="_blank" rel="noopener" class="sb-social-btn" aria-label="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://wa.me/34927534821" target="_blank" rel="noopener" class="sb-social-btn" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                    <p style="font-size:13px;color:rgba(255,255,255,.28);margin-top:16px;line-height:1.65;">
                        Síguenos para ver los últimos<br>cortes, estilos y novedades.
                    </p>
                </div>
            </div>
            <div class="sb-footer-bottom">
                © {{ date('Y') }} ST BARBER &middot; Todos los derechos reservados
            </div>
        </div>
    </footer>
    @include('components.modal-login')
    @include('components.modal-registro')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: @json(session('success')),
                timer: 2000,
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
                borderRadius: '12px',
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
    @if(session('_form_type') === 'login' && $errors->any())
    <script>
    (function() {
        function abrirModal() {
            if (typeof bootstrap !== 'undefined' && document.getElementById('modalLogin')) {
                new bootstrap.Modal(document.getElementById('modalLogin')).show();
            } else {
                setTimeout(abrirModal, 50);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { setTimeout(abrirModal, 100); });
        } else {
            setTimeout(abrirModal, 100);
        }
    })();
    </script>
    @endif
    @if($errors->any() && old('_form_type') === 'registro')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('modalRegistro')).show();
    });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
