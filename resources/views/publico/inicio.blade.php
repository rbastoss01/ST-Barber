@extends('layouts.app')

@section('title', 'ST BARBER — Tu peluquería de confianza')

@push('styles')
<style>
    .sb-hero {
        display: grid;
        grid-template-columns: 1fr 42%;
        height: 75vh;
        background-color: #111111;
        background-image: radial-gradient(rgba(255,255,255,.055) 1px, transparent 1px);
        background-size: 28px 28px;
        overflow: hidden;
    }

    .sb-hero-text {
        display: flex;
        align-items: center;
        padding: 60px 48px 60px 100px;
    }

    .sb-hero-text .container {
        max-width: 100%;
        padding: 0;
        width: 100%;
    }

    .sb-hero-image {
        overflow: hidden;
    }

    .sb-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    @media (max-width: 991.98px) {
        .sb-hero {
            grid-template-columns: 1fr;
        }
        .sb-hero-text {
            padding: 80px 32px;
            justify-content: center;
            text-align: center;
        }
        .sb-hero-text .container {
            width: 100%;
            padding: 0;
        }
        .sb-hero-eyebrow,
        .sb-hero-rule,
        .d-flex.flex-wrap.gap-3 {
            justify-content: center;
        }
        .sb-hero-sub {
            margin-left: auto;
            margin-right: auto;
        }
        .sb-hero-image {
            display: none;
        }
    }

    .sb-hero-eyebrow {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
    }

    .sb-hero-eyebrow-line {
        width: 32px;
        height: 1px;
        background: rgba(255,255,255,.25);
        flex-shrink: 0;
    }

    .sb-hero-eyebrow-text {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,.35);
        font-weight: 600;
    }

    .sb-hero h1 {
        font-size: clamp(48px, 6.5vw, 88px);
        font-weight: 800;
        line-height: 1.0;
        color: #fff;
        margin-bottom: 18px;
        letter-spacing: -3px;
    }

    .sb-hero h1 .dim {
        color: rgba(255,255,255,.2);
    }

    .sb-hero-rule {
        width: 36px;
        height: 2px;
        background: #fff;
        margin-bottom: 12px;
    }

    .sb-hero-sub {
        font-size: 18px;
        color: rgba(255,255,255,.45);
        line-height: 1.7;
        max-width: 100%;
        margin-bottom: 28px;
    }

    .btn-hero-primary {
        background: #ffffff;
        color: #111111;
        font-weight: 700;
        font-size: 16px;
        padding: 16px 36px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: background .2s;
        font-family: 'Inter', sans-serif;
    }

    .btn-hero-primary:hover {
        background: #f0f0f0;
        color: #111111;
    }

    .btn-hero-secondary {
        background: transparent;
        color: rgba(255,255,255,.7);
        font-weight: 600;
        font-size: 16px;
        padding: 16px 36px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid rgba(255,255,255,.2);
        transition: background .2s, border-color .2s, color .2s;
    }

    .btn-hero-secondary:hover {
        background: rgba(255,255,255,.06);
        border-color: rgba(255,255,255,.4);
        color: #fff;
    }

    .sb-section-title {
        font-size: clamp(24px, 3.5vw, 36px);
        font-weight: 800;
        color: #111;
        line-height: 1.2;
        margin-bottom: 8px;
        letter-spacing: -.3px;
    }

    .sb-section-sub {
        font-size: 15px;
        color: #6B7280;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .sb-cta {
        padding: 96px 0;
        background: #ffffff;
        border-top: 1px solid #E9ECEF;
    }

    .sb-cta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .sb-cta-title {
        font-size: clamp(32px, 4.5vw, 54px);
        font-weight: 800;
        color: #111111;
        line-height: 1.06;
        letter-spacing: -1.5px;
        margin-bottom: 20px;
    }

    .sb-cta-sub {
        font-size: 16px;
        color: #6B7280;
        line-height: 1.75;
        margin: 0;
        max-width: 400px;
    }

    .btn-cta-primary {
        background: #111111;
        color: #ffffff;
        font-weight: 700;
        font-size: 14px;
        padding: 14px 30px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: background .2s;
        font-family: 'Inter', sans-serif;
    }

    .btn-cta-primary:hover { background: #333333; color: #fff; }

    .btn-cta-secondary {
        background: transparent;
        color: #111111;
        font-weight: 600;
        font-size: 14px;
        padding: 14px 30px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid #111111;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all .2s;
    }

    .btn-cta-secondary:hover { background: #111111; color: #fff; }

    .sb-cta-perks {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .sb-cta-perks li {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 15px;
        font-weight: 500;
        color: #374151;
    }

    .sb-cta-perks li i {
        font-size: 19px;
        color: #111111;
        flex-shrink: 0;
    }

    @media (max-width: 767.98px) {
        .sb-cta-grid {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }
        .sb-cta-sub { max-width: 100%; }
        .sb-cta-grid .d-flex { justify-content: center; }
        .sb-cta-perks { align-items: center; }
        .sb-cta-perks li { justify-content: center; }
    }

    .sb-steps {
        padding: 80px 0;
        background: #F8F8F8;
        border-top: 1px solid #E9ECEF;
    }

    .sb-step {
        padding-right: 32px;
    }

    .sb-step-num {
        font-size: 52px;
        font-weight: 800;
        color: #E9ECEF;
        line-height: 1;
        margin-bottom: 18px;
        letter-spacing: -2px;
    }

    .sb-step-title {
        font-size: 17px;
        font-weight: 700;
        color: #111;
        margin-bottom: 10px;
    }

    .sb-step-desc {
        font-size: 14px;
        color: #6B7280;
        line-height: 1.7;
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .sb-step { padding-left: 16px; padding-right: 16px; }
    }

    @media (min-width: 768px) {
        .sb-step { border-right: 1px solid #E9ECEF; }
        .col-md-4:last-child .sb-step { border-right: none; padding-right: 0; padding-left: 32px; }
        .col-md-4:nth-child(2) .sb-step { padding-left: 32px; }
    }

    .sb-services {
        padding: 80px 0;
        background: #F8F8F8;
    }

    .sb-srv-row {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #E9ECEF;
        border-radius: 12px;
        padding: 20px 24px;
        transition: box-shadow .2s;
    }

    .sb-srv-row:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,.07);
    }

    .sb-srv-name {
        font-size: 15px;
        font-weight: 700;
        color: #111;
        flex: 1;
    }

    .sb-srv-meta {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .sb-srv-duration {
        font-size: 13px;
        color: #9CA3AF;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .sb-srv-price {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        min-width: 64px;
        text-align: right;
    }

    .sb-info {
        padding: 64px 0;
        background: #fff;
        border-top: 1px solid #E9ECEF;
    }

    .sb-info-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .sb-info-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #111111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        flex-shrink: 0;
    }

    .sb-info-label {
        font-size: 11px;
        font-weight: 700;
        color: #111;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .sb-info-text {
        font-size: 14px;
        color: #6B7280;
        line-height: 1.65;
    }
</style>
@endpush

@section('content')
<section class="sb-hero">
    <div class="sb-hero-text">
        <div class="container">
            <div class="sb-hero-eyebrow">
                <div class="sb-hero-eyebrow-line"></div>
                <span class="sb-hero-eyebrow-text">ST BARBER · CÁCERES</span>
            </div>
            <h1>
                Corte.<br>
                Estilo.<br>
                <span class="dim">Confianza.</span>
            </h1>
            <div class="sb-hero-rule"></div>
            <p class="sb-hero-sub">
                Reserva tu cita online en segundos.<br>
                Sin esperas. Sin llamadas.
            </p>
            <div class="d-flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('citas.reservar') }}" class="btn-hero-primary">
                        <i class="bi bi-calendar-plus"></i> Reservar cita
                    </a>
                @else
                    <button class="btn-hero-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                        <i class="bi bi-calendar-plus"></i> Reservar cita
                    </button>
                @endauth
                <a href="{{ route('servicios') }}" class="btn-hero-secondary">
                    Ver servicios <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sb-hero-image" aria-hidden="true">
        <img src="/images/hero.jpg" alt="">
    </div>
</section>

<section class="sb-cta">
    <div class="container">
        <div class="sb-cta-grid">
            <div>
                <h2 class="sb-cta-title">
                    El corte que<br>mereces, cuando<br>tú quieras.
                </h2>
                <p class="sb-cta-sub">
                    Únete a ST BARBER. Elige tu barbero, tu horario
                    y reserva tu cita.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    @guest
                        <button class="btn-cta-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                            <i class="bi bi-person-plus"></i> Crear cuenta gratis
                        </button>
                        <button class="btn-cta-secondary" data-bs-toggle="modal" data-bs-target="#modalLogin">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </button>
                    @else
                        <a href="{{ route('citas.reservar') }}" class="btn-cta-primary">
                            <i class="bi bi-calendar-plus"></i> Reservar cita
                        </a>
                    @endguest
                </div>
            </div>
            <ul class="sb-cta-perks">
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Sin llamadas ni desplazamientos innecesarios
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Elige tu barbero favorito
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Modifica o cancela cuando quieras
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Disponible siempre
                </li>
            </ul>

        </div>
    </div>
</section>

<section class="sb-services">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5">
            <div>
                <h2 class="sb-section-title">Nuestros servicios</h2>
                <p class="sb-section-sub">Precios claros, sin sorpresas.</p>
            </div>
            <a href="{{ route('servicios') }}" class="text-decoration-none" style="font-size:14px;font-weight:600;color:#111;">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($serviciosDestacados->isEmpty())
            <div class="d-flex flex-column gap-3">
                @foreach([
                    ['Corte de pelo', 30, 15],
                    ['Arreglo de barba', 20, 10],
                    ['Corte + Barba', 45, 22],
                    ['Afeitado con navaja', 35, 18],
                ] as [$nombre, $duracion, $precio])
                <div class="sb-srv-row">
                    <span class="sb-srv-name">{{ $nombre }}</span>
                    <div class="sb-srv-meta">
                        <span class="sb-srv-duration">
                            <i class="bi bi-clock"></i> {{ $duracion }} min
                        </span>
                        <span class="sb-srv-price">{{ $precio }} €</span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($serviciosDestacados as $servicio)
                <div class="sb-srv-row">
                    <span class="sb-srv-name">{{ $servicio->nombre }}</span>
                    <div class="sb-srv-meta">
                        <span class="sb-srv-duration">
                            <i class="bi bi-clock"></i> {{ $servicio->duracion }} min
                        </span>
                        <span class="sb-srv-price">
                            {{ number_format($servicio->precio, 2, ',', '.') }} €
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="sb-steps">
    <div class="container">
        <div class="mb-5">
            <h2 class="sb-section-title">Así de fácil</h2>
            <p class="sb-section-sub">Reservar es muy sencillo.</p>
        </div>
        <div class="row g-4 g-md-0">
            <div class="col-md-4">
                <div class="sb-step">
                    <div class="sb-step-num">01</div>
                    <div class="sb-step-title">Crea tu cuenta</div>
                    <p class="sb-step-desc">Crea tu cuenta en segundos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sb-step">
                    <div class="sb-step-num">02</div>
                    <div class="sb-step-title">Elige tu cita</div>
                    <p class="sb-step-desc">Elige servicio, barbero y hora.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sb-step">
                    <div class="sb-step-num">03</div>
                    <div class="sb-step-title">Disfruta tu corte</div>
                    <p class="sb-step-desc">Llega a tu hora y listo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
