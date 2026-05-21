@extends('layouts.app')

@section('title', 'Cita confirmada — ST BARBER')

@section('content')

<div style="min-height:80vh;display:flex;align-items:center;padding:48px 16px;background:#F5F5F5;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="text-center mb-4">
                    <div style="width:72px;height:72px;border-radius:50%;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="bi bi-check-lg" style="font-size:34px;color:#16A34A;"></i>
                    </div>
                    <h1 style="font-size:24px;font-weight:800;color:#111;margin-bottom:6px;">
                        ¡Cita reservada con éxito!
                    </h1>
                    <p style="font-size:14px;color:#6B7280;">
                        Te esperamos en ST BARBER. Recibirás un recordatorio el día anterior.
                    </p>
                </div>

                <div style="background:#fff;border:1px solid #E9ECEF;border-radius:16px;overflow:hidden;margin-bottom:20px;">
                    <div style="background:#111111;padding:20px 24px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                            <div>
                                <div style="font-size:11px;font-weight:700;letter-spacing:2px;color:rgba(255,255,255,.4);text-transform:uppercase;margin-bottom:4px;">
                                    ST BARBER
                                </div>
                                <div style="font-size:18px;font-weight:800;color:#fff;">
                                    {{ $cita->servicio->nombre }}
                                </div>
                            </div>
                            @php $badgeStyle = match($cita->estado) {
                                'CONFIRMADA' => 'background:rgba(22,163,74,.2);color:#86EFAC;',
                                default      => 'background:rgba(239,68,68,.2);color:#FCA5A5;',
                            }; @endphp
                            <span style="border-radius:999px;padding:5px 14px;font-size:11.5px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;{{ $badgeStyle }}">
                                {{ $cita->estado }}
                            </span>
                        </div>
                    </div>

                    <div style="padding:24px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">
                            <div style="display:flex;gap:12px;align-items:flex-start;">
                                <div style="width:36px;height:36px;border-radius:9px;background:#F3F4F6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-calendar3" style="color:#111111;font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:11px;color:#9CA3AF;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Fecha</div>
                                    <div style="font-size:14px;font-weight:700;color:#111;">
                                        {{ ucfirst($cita->fecha->translatedFormat('l')) }}, {{ $cita->fecha->format('d') }} de {{ ucfirst($cita->fecha->translatedFormat('F')) }} de {{ $cita->fecha->format('Y') }}
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex;gap:12px;align-items:flex-start;">
                                <div style="width:36px;height:36px;border-radius:9px;background:#F3F4F6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-clock" style="color:#111111;font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:11px;color:#9CA3AF;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Hora</div>
                                    <div style="font-size:14px;font-weight:700;color:#111;">
                                        {{ substr($cita->hora, 0, 5) }}
                                        <span style="color:#9CA3AF;font-weight:400;font-size:12px;">
                                            ({{ $cita->servicio->duracion }} min)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex;gap:12px;align-items:flex-start;">
                                <div style="width:36px;height:36px;border-radius:9px;background:#F3F4F6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-scissors" style="color:#111111;font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:11px;color:#9CA3AF;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Peluquero</div>
                                    <div style="font-size:14px;font-weight:700;color:#111;">
                                        {{ $cita->peluquero->nombre }} {{ $cita->peluquero->apellidos }}
                                    </div>
                                    <div style="font-size:12px;color:#6B7280;">{{ $cita->peluquero->especialidad }}</div>
                                </div>
                            </div>

                            <div style="display:flex;gap:12px;align-items:flex-start;">
                                <div style="width:36px;height:36px;border-radius:9px;background:#F3F4F6;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-tag" style="color:#111111;font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:11px;color:#9CA3AF;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;">Precio</div>
                                    <div style="font-size:20px;font-weight:800;color:#111111;">
                                        {{ number_format($cita->servicio->precio, 2, ',', '.') }} €
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($cita->observaciones)
                            <div style="margin-top:16px;padding:12px 16px;background:#F9FAFB;border-radius:10px;font-size:13.5px;color:#6B7280;">
                                <i class="bi bi-chat-dots me-2" style="color:#6B7280;"></i>
                                {{ $cita->observaciones }}
                            </div>
                        @endif
                    </div>

                    <div style="padding:0 24px 24px;">
                        <a href="{{ route('citas.ics', $cita->id_cita) }}" style="display:flex;align-items:center;justify-content:center;gap:8px;background:#F3F4F6;color:#374151;border:1.5px solid #E9ECEF;border-radius:10px;padding:12px;font-size:14px;font-weight:600;text-decoration:none;transition:all .2s;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                            <i class="bi bi-calendar-event" style="font-size:16px;"></i>
                            Añadir al calendario
                        </a>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('citas.index') }}" style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;background:#111111;color:#fff;border-radius:10px;padding:12px;font-size:14px;font-weight:700;text-decoration:none;transition:background .2s;" onmouseover="this.style.background='#333333'" onmouseout="this.style.background='#111111'">
                        <i class="bi bi-calendar3"></i> Ver mis citas
                    </a>
                    <a href="{{ route('citas.reservar') }}" style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;background:#fff;color:#111111;border:1.5px solid #111111;border-radius:10px;padding:12px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-calendar-plus"></i> Reservar otra
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
