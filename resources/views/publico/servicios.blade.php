@extends('layouts.app')

@section('title', 'Servicios — ST BARBER')

@push('styles')
<style>
    .sb-page-header {
        background: #111111;
        padding: 56px 0 52px;
        position: relative;
        overflow: hidden;
    }

    .sb-page-header-tag {
        display: inline-block;
        background: rgba(255,255,255,.1);
        color: rgba(255,255,255,.75);
        border: 1px solid rgba(255,255,255,.15);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-radius: 999px;
        padding: 4px 14px;
        margin-bottom: 12px;
    }

    .sb-page-header h1 {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: #fff;
        margin-bottom: 10px;
        letter-spacing: -.3px;
    }

    .sb-page-header p {
        font-size: 16px;
        color: rgba(255,255,255,.5);
        max-width: 480px;
        margin: 0;
    }

    .sb-service-card {
        background: #fff;
        border: 1px solid #E9ECEF;
        border-radius: 14px;
        padding: 28px 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }

    .sb-service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.08);
        border-color: #ccc;
    }

    .sb-service-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #111111;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 24px;
        color: #fff;
        flex-shrink: 0;
    }

    .sb-service-name {
        font-size: 18px;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .sb-service-desc {
        font-size: 13.5px;
        color: #6B7280;
        line-height: 1.65;
        flex: 1;
        margin-bottom: 20px;
    }

    .sb-service-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-top: 1px solid #F3F4F6;
        border-bottom: 1px solid #F3F4F6;
        margin-bottom: 16px;
    }

    .sb-service-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #F3F4F6;
        color: #6B7280;
        font-size: 12px;
        font-weight: 600;
        border-radius: 999px;
        padding: 4px 12px;
    }

    .sb-service-price {
        font-size: 26px;
        font-weight: 800;
        color: #111111;
        line-height: 1;
    }

    .btn-reservar {
        display: block;
        text-align: center;
        background: #111111;
        color: #fff;
        border-radius: 9px;
        padding: 11px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        width: 100%;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-reservar:hover {
        background: #333333;
        color: #fff;
    }

    .sb-empty {
        text-align: center;
        padding: 80px 20px;
        color: #9CA3AF;
    }

    .sb-empty i { font-size: 56px; margin-bottom: 16px; display: block; }
    .sb-empty h3 { font-size: 20px; color: #374151; margin-bottom: 8px; }
    .sb-empty p  { font-size: 14px; }
</style>
@endpush

@section('content')

<div class="sb-page-header">
    <div class="container position-relative" style="z-index:1;">
        <div class="sb-page-header-tag">
            <i class="bi bi-scissors me-1"></i>Servicios
        </div>
        <h1>Nuestros servicios</h1>
        <p>Todos los precios incluyen el mejor trato y la máxima profesionalidad.</p>
    </div>
</div>

<div class="container py-5">
    @if($servicios->isEmpty())
        <div class="sb-empty">
            <i class="bi bi-scissors"></i>
            <h3>Próximamente</h3>
            <p>Estamos preparando nuestro catálogo de servicios.<br>Vuelve pronto.</p>
        </div>
    @else
        @php
            $iconos = [
                'bi-scissors',
                'bi-badge-cc',
                'bi-stars',
                'bi-droplet',
                'bi-brush',
                'bi-gem',
            ];
        @endphp

        <div class="row g-4">
            @foreach($servicios as $i => $servicio)
            <div class="col-sm-6 col-lg-4">
                <div class="sb-service-card">
                    <div class="sb-service-icon">
                        <i class="bi {{ $iconos[$i % count($iconos)] }}"></i>
                    </div>

                    <div class="sb-service-name">{{ $servicio->nombre }}</div>

                    <p class="sb-service-desc">
                        {{ $servicio->descripcion ?: 'Servicio profesional realizado por nuestros especialistas.' }}
                    </p>

                    <div class="sb-service-meta">
                        <span class="sb-service-badge">
                            <i class="bi bi-clock"></i>
                            {{ $servicio->duracion }} min
                        </span>
                        <span class="sb-service-price">
                            {{ number_format($servicio->precio, 2, ',', '.') }} €
                        </span>
                    </div>

                    @auth
                        <a href="{{ route('citas.reservar', $servicio->id_servicio) }}" class="btn-reservar">
                            <i class="bi bi-calendar-plus me-1"></i> Reservar este servicio
                        </a>
                    @else
                        <button class="btn-reservar" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                            <i class="bi bi-calendar-plus me-1"></i> Reservar este servicio
                        </button>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
