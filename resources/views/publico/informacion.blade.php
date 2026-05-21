@extends('layouts.app')

@section('title', 'Información — ST BARBER')

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

    .sb-info-card {
        background: #fff;
        border: 1px solid #E9ECEF;
        border-radius: 14px;
        padding: 28px;
        height: 100%;
    }

    .sb-info-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F3F4F6;
    }

    .sb-info-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #F3F4F6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #111111;
        flex-shrink: 0;
    }

    .sb-info-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #111;
        margin: 0;
    }

    .sb-info-row {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .sb-info-row:last-child { margin-bottom: 0; }

    .sb-info-row i {
        color: #111111;
        font-size: 16px;
        margin-top: 1px;
        flex-shrink: 0;
        width: 18px;
        text-align: center;
    }

    .sb-info-row-label {
        color: #6B7280;
        font-weight: 500;
        min-width: 130px;
    }

    .sb-info-row-value {
        color: #374151;
        font-weight: 600;
    }

    .sb-horario-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #F9FAFB;
        font-size: 14px;
    }

    .sb-horario-row:last-child { border-bottom: none; }

    .sb-horario-dia {
        color: #374151;
        font-weight: 600;
    }

    .sb-horario-hora {
        color: #6B7280;
        font-weight: 500;
    }

    .sb-horario-closed {
        color: #EF4444;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .sb-today {
        background: rgba(0,0,0,.04);
        border-radius: 8px;
        padding: 10px 10px;
        margin: 0 -10px;
    }

    .sb-today .sb-horario-dia { color: #111111; }

    .sb-map-placeholder {
        background: #F3F4F6;
        border: 1px solid #E9ECEF;
        border-radius: 14px;
        height: 360px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9CA3AF;
        text-align: center;
        overflow: hidden;
    }

    .sb-map-placeholder iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 14px;
    }
</style>
@endpush

@section('content')

<div class="sb-page-header">
    <div class="container position-relative" style="z-index:1;">
        <div class="sb-page-header-tag">
            <i class="bi bi-geo-alt me-1"></i>Información
        </div>
        <h1>¿Cómo encontrarnos?</h1>
        <p>Toda la información que necesitas para visitarnos o contactar con nosotros.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="row g-4">
                <div class="col-12">
                    <div class="sb-info-card">
                        <div class="sb-info-card-header">
                            <div class="sb-info-card-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h2 class="sb-info-card-title">Ubicación y contacto</h2>
                        </div>

                        <div class="sb-info-row">
                            <i class="bi bi-map"></i>
                            <div>
                                <div class="sb-info-row-label">Dirección</div>
                                <div class="sb-info-row-value">Calle Medellín 11, Navalmoral de la Mata</div>
                            </div>
                        </div>

                        <div class="sb-info-row">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <div class="sb-info-row-label">Teléfono</div>
                                <div class="sb-info-row-value">
                                    <a href="tel:+34927534821"
                                       style="color:#374151;text-decoration:none;">
                                        927 534 821
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sb-info-row">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <div class="sb-info-row-label">Email</div>
                                <div class="sb-info-row-value">
                                    <a href="mailto:info@stbarber.com"
                                       style="color:#111111;text-decoration:none;">
                                        info@stbarber.com
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sb-info-row">
                            <i class="bi bi-instagram"></i>
                            <div>
                                <div class="sb-info-row-label">Instagram</div>
                                <div class="sb-info-row-value">
                                    <a href="https://instagram.com/stbarber" target="_blank"
                                       rel="noopener"
                                       style="color:#111111;text-decoration:none;">
                                        @stbarber
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="sb-map-placeholder">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3061.2567897918466!2d-5.542103822796272!3d39.89088263747457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3fd92db2ef6493%3A0x5c757bc47dc7c5c7!2sMACHUCA%20BARBER%C3%8DA.!5e0!3m2!1ses!2ses!4v1778780250354!5m2!1ses!2ses" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sb-info-card mb-4">
                <div class="sb-info-card-header">
                    <div class="sb-info-card-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <h2 class="sb-info-card-title">Horario de apertura</h2>
                </div>

                @php
                    $diaSemana = now()->dayOfWeekIso; // 1=Lunes, 7=Domingo
                @endphp

                <div class="sb-horario-row {{ $diaSemana == 1 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Lunes
                        @if($diaSemana == 1)
                            <span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;vertical-align:middle;">HOY</span>
                        @endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 20:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 2 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Martes
                        @if($diaSemana == 2)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 20:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 3 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Miércoles
                        @if($diaSemana == 3)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 20:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 4 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Jueves
                        @if($diaSemana == 4)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 20:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 5 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Viernes
                        @if($diaSemana == 5)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 20:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 6 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Sábado
                        @if($diaSemana == 6)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-hora">9:00 — 14:00</span>
                </div>
                <div class="sb-horario-row {{ $diaSemana == 7 ? 'sb-today' : '' }}">
                    <span class="sb-horario-dia">
                        Domingo
                        @if($diaSemana == 7)<span style="font-size:10px;font-weight:700;color:#111;margin-left:6px;">HOY</span>@endif
                    </span>
                    <span class="sb-horario-closed">Cerrado</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
