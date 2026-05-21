@extends('layouts.app')

@section('title', $cita !== null ? 'Modificar cita — ST BARBER' : 'Reservar cita — ST BARBER')

@push('styles')
<style>
    body { background:#F5F5F5; }

    .sb-paso {
        background:#fff;border:1px solid #E9ECEF;border-radius:14px;
        padding:24px;margin-bottom:16px;
    }
    .sb-paso-titulo {
        display:flex;align-items:center;gap:10px;
        font-size:14px;font-weight:700;color:#111;margin-bottom:18px;
    }
    .sb-paso-num {
        width:26px;height:26px;border-radius:50%;
        background:#111111;color:#fff;
        font-size:12px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }

    .sb-servicio-chip {
        padding:12px 16px;border-radius:11px;
        border:1.5px solid #E9ECEF;cursor:pointer;
        transition:all .18s;background:#fff;text-align:left;width:100%;
        font-family:'Inter',sans-serif;
    }
    .sb-servicio-chip:hover { border-color:#111111;background:rgba(0,0,0,.03); }
    .sb-servicio-chip.selected { border-color:#111111;background:rgba(0,0,0,.05); }
    .sb-servicio-chip .chip-nombre { font-size:14px;font-weight:700;color:#111;display:block; }
    .sb-servicio-chip .chip-meta   { font-size:12px;color:#9CA3AF;margin-top:2px;display:flex;gap:8px; }
    .sb-servicio-chip .chip-precio { font-size:15px;font-weight:800;color:#111111;float:right; }

    .sb-cal-nav {
        width:34px;height:34px;border-radius:8px;border:1.5px solid #E9ECEF;
        background:#fff;display:flex;align-items:center;justify-content:center;
        cursor:pointer;color:#374151;font-size:14px;flex-shrink:0;transition:all .15s;
    }
    .sb-cal-nav:hover:not(:disabled) { border-color:#111111;color:#111111; }
    .sb-cal-nav:disabled { opacity:.35;cursor:default; }

    .sb-cal-semana {
        display:flex;gap:6px;flex:1;overflow-x:auto;padding-bottom:4px;
    }
    .sb-cal-dia {
        flex:1;min-width:52px;max-width:72px;
        padding:10px 6px;border-radius:11px;
        border:1.5px solid #E9ECEF;cursor:pointer;text-align:center;
        transition:all .18s;background:#fff;font-family:'Inter',sans-serif;
        display:flex;flex-direction:column;align-items:center;gap:2px;
    }
    .sb-cal-dia:hover:not(.disabled) { border-color:#111111;background:rgba(0,0,0,.03); }
    .sb-cal-dia.selected { border-color:#111111;background:#111111;color:#fff; }
    .sb-cal-dia.disabled { opacity:.35;cursor:default;background:#F9FAFB; }
    .sb-cal-dia.hoy:not(.selected) { border-color:#111111; }
    .sb-cal-dia .dia-nombre { font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;opacity:.6; }
    .sb-cal-dia .dia-num    { font-size:18px;font-weight:800;line-height:1; }
    .sb-cal-dia .dia-mes    { font-size:9px;opacity:.55; }
    .sb-cal-dia.selected .dia-nombre,
    .sb-cal-dia.selected .dia-mes { opacity:.75; }

    .sb-peluquero-card {
        display:flex;align-items:center;gap:12px;
        padding:12px 16px;border-radius:11px;
        border:1.5px solid #E9ECEF;cursor:pointer;
        transition:all .18s;background:#fff;font-family:'Inter',sans-serif;
        text-align:left;width:100%;
    }
    .sb-peluquero-card:hover { border-color:#111111;background:rgba(0,0,0,.03); }
    .sb-peluquero-card.selected { border-color:#111111;background:rgba(0,0,0,.05); }
    .sb-peluquero-avatar {
        width:40px;height:40px;border-radius:50%;
        background:#111111;color:#fff;
        font-size:15px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .sb-peluquero-nombre    { font-size:14px;font-weight:700;color:#111; }
    .sb-peluquero-specialty { font-size:12px;color:#9CA3AF; }

    .sb-slots-label {
        font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;
        color:#9CA3AF;margin:16px 0 10px;
    }
    .sb-slots-grid { display:flex;flex-wrap:wrap;gap:8px; }
    .sb-slot {
        padding:9px 14px;border-radius:9px;border:1.5px solid #E9ECEF;
        font-size:13.5px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;
        background:#fff;color:#374151;transition:all .15s;
    }
    .sb-slot:hover:not(.ocupado) { border-color:#111111;color:#111111;background:rgba(0,0,0,.03); }
    .sb-slot.selected { border-color:#111111;background:#111111;color:#fff; }
    .sb-slot.ocupado  { background:#F9FAFB;color:#D1D5DB;border-color:#F3F4F6;cursor:not-allowed;text-decoration:line-through; }
    .sb-slots-loading {
        display:flex;align-items:center;gap:8px;
        font-size:13.5px;color:#9CA3AF;padding:12px 0;
    }

    .btn-confirmar {
        background:#111111;color:#fff;border:none;border-radius:10px;
        padding:12px 28px;font-size:14px;font-weight:700;cursor:pointer;
        font-family:'Inter',sans-serif;transition:background .2s;
    }
    .btn-confirmar:hover { background:#333333; }

    .sb-contenido-reserva { padding-bottom:24px; }
</style>
@endpush

@section('content')
<div class="sb-contenido-reserva">

    <div style="background:#111;padding:36px 0 32px;">
        <div class="container">
            <div style="font-size:11px;font-weight:700;letter-spacing:2px;color:rgba(255,255,255,.5);text-transform:uppercase;margin-bottom:8px;">
                {{ $cita !== null ? 'Modificar' : 'Nueva' }} cita
            </div>
            <h1 style="font-size:clamp(22px,3.5vw,32px);font-weight:800;color:#fff;margin:0;">
                {{ $cita !== null ? 'Modifica tu cita' : 'Reserva tu cita' }}
            </h1>
        </div>
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">

                @if(session('error'))
                <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 16px;margin-bottom:16px;display:flex;gap:10px;">
                    <i class="bi bi-exclamation-circle-fill" style="color:#DC2626;flex-shrink:0;"></i>
                    <span style="font-size:13.5px;color:#991B1B;">{{ session('error') }}</span>
                </div>
                @endif

                <form id="formReserva" method="POST"
                      action="{{ $cita !== null ? route('citas.actualizar', $cita->id_cita) : route('citas.guardar') }}">
                    @csrf
                    @if($cita !== null) @method('PUT') @endif

                    <input type="hidden" id="input-servicio"  name="id_servicio">
                    <input type="hidden" id="input-peluquero" name="id_peluquero">
                    <input type="hidden" id="input-fecha"     name="fecha">
                    <input type="hidden" id="input-hora"      name="hora">

                    <div class="sb-paso">
                        <div class="sb-paso-titulo">
                            <span class="sb-paso-num">1</span> Elige el servicio
                        </div>
                        <div class="row g-2">
                            @foreach($servicios as $srv)
                            <div class="col-sm-6">
                                <button type="button" class="sb-servicio-chip"
                                        data-id="{{ $srv->id_servicio }}"
                                        data-nombre="{{ $srv->nombre }}"
                                        data-precio="{{ $srv->precio }}"
                                        data-duracion="{{ $srv->duracion }}">
                                    <span class="chip-precio">{{ number_format($srv->precio, 0) }}€</span>
                                    <span class="chip-nombre">{{ $srv->nombre }}</span>
                                    <span class="chip-meta">
                                        <span><i class="bi bi-clock me-1"></i>{{ $srv->duracion }} min</span>
                                        @if($srv->descripcion)
                                            <span>{{ Str::limit($srv->descripcion, 40) }}</span>
                                        @endif
                                    </span>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="sb-paso">
                        <div class="sb-paso-titulo">
                            <span class="sb-paso-num">2</span> Elige la fecha
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                            <span id="rango-semana" style="font-size:13px;font-weight:600;color:#6B7280;"></span>
                            <div style="display:flex;gap:6px;">
                                <button type="button" class="sb-cal-nav" id="btn-semana-ant">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="sb-cal-nav" id="btn-semana-sig">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sb-cal-semana" id="cal-semana"></div>
                    </div>

                    <div class="sb-paso">
                        <div class="sb-paso-titulo">
                            <span class="sb-paso-num">3</span> Elige el peluquero
                        </div>
                        <div class="row g-2">
                            @foreach($peluqueros as $pel)
                            <div class="col-sm-6 col-md-4">
                                <button type="button" class="sb-peluquero-card" data-id="{{ $pel->id_peluquero }}" data-nombre="{{ $pel->nombre }} {{ $pel->apellidos }}">
                                    <div class="sb-peluquero-avatar">
                                        {{ strtoupper(substr($pel->nombre, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="sb-peluquero-nombre">{{ $pel->nombre }}</div>
                                        <div class="sb-peluquero-specialty">{{ $pel->especialidad }}</div>
                                    </div>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="sb-paso">
                        <div class="sb-paso-titulo">
                            <span class="sb-paso-num">4</span> Elige la hora
                        </div>
                        <div id="slots-container">
                            <div style="padding:24px 0;text-align:center;color:#9CA3AF;font-size:14px;">
                                <i class="bi bi-arrow-up-circle" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                Completa los pasos anteriores para ver las horas disponibles
                            </div>
                        </div>
                    </div>

                    <div class="sb-paso">
                        <div class="sb-paso-titulo">
                            <span class="sb-paso-num" style="background:#E5E7EB;color:#6B7280;">✦</span>
                            Observaciones
                            <span style="font-size:12px;color:#9CA3AF;font-weight:400;">(opcional)</span>
                        </div>
                        <textarea name="observaciones" rows="3" placeholder="¿Tienes alguna indicación especial para el peluquero?" style="width:100%;border:1.5px solid #E9ECEF;border-radius:10px;padding:12px;font-size:14px;font-family:'Inter',sans-serif;resize:vertical;outline:none;transition:border-color .2s;" onfocus="this.style.borderColor='#111111'" onblur="this.style.borderColor='#E9ECEF'">{{ old('observaciones', $cita?->observaciones ?? '') }}</textarea>
                    </div>

                </form>

                <div id="botones-confirmar" style="display:none;gap:12px;align-items:center;flex-wrap:wrap;justify-content:center;margin-top:8px;margin-bottom:16px;">
                    <button type="button" class="btn-confirmar"
                            onclick="document.getElementById('formReserva').submit()">
                        <i class="bi bi-check-lg me-1"></i>
                        {{ $cita !== null ? 'Guardar cambios' : 'Confirmar cita' }}
                    </button>
                    <a href="{{ route('citas.index') }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:12px 24px;border-radius:10px;border:1.5px solid #E9ECEF;background:#fff;color:#6B7280;font-size:14px;font-weight:600;text-decoration:none;font-family:'Inter',sans-serif;transition:border-color .2s,color .2s;"
                       onmouseover="this.style.borderColor='#111111';this.style.color='#111111'"
                       onmouseout="this.style.borderColor='#E9ECEF';this.style.color='#6B7280'">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </a>
                </div>

            </div>
        </div>
    </div>


</div>
@endsection

@push('scripts')
<script>
(function () {
    var URL_DISP     = @json(route('disponibilidad'));
    var MODO_EDICION = @json($cita !== null);
    var CITA_ID      = @json($cita ? (int)$cita->id_cita : null);

    var st = {
        servicioId:       @json($cita ? (int)$cita->id_servicio : ($servicioPreseleccionado ? (int)$servicioPreseleccionado->id_servicio : null)),
        servicioNombre:   @json($cita !== null ? $cita->servicio->nombre : ($servicioPreseleccionado?->nombre ?? '')),
        servicioPrecio:   @json($cita !== null ? (float)$cita->servicio->precio : (float)($servicioPreseleccionado?->precio ?? 0)),
        servicioDuracion: @json($cita !== null ? (int)$cita->servicio->duracion : (int)($servicioPreseleccionado?->duracion ?? 30)),
        peluqueroId:      @json($cita ? (int)$cita->id_peluquero : null),
        peluqueroNombre:  @json($cita !== null ? ($cita->peluquero->nombre.' '.$cita->peluquero->apellidos) : ''),
        fecha:            @json($cita?->fecha?->format('Y-m-d')),
        fechaDisplay:     '',
        hora:             @json($cita !== null ? substr($cita->hora, 0, 5) : null),
        semanaOffset:     0,
    };

    var DIAS_CORTO = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
    var DIAS_LARGO = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    var MESES      = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

    document.addEventListener('DOMContentLoaded', function () {
        if (st.fecha) {
            var hoy   = hoyLocal();
            var dow   = hoy.getDay();
            var diffL = dow === 0 ? -6 : 1 - dow;
            var lHoy  = new Date(hoy);
            lHoy.setDate(lHoy.getDate() + diffL);
            var target   = parseLocalDate(st.fecha);
            var diffDays = Math.floor((target - lHoy) / 864e5);
            st.semanaOffset = Math.max(0, Math.floor(diffDays / 7));
            st.fechaDisplay = formatFecha(st.fecha);
        }

        generarCalendario();
        wireServicios();
        wirePeluqueros();
        actualizarHiddens();
        actualizarBarra();

        if (st.fecha && st.peluqueroId && st.servicioId) {
            cargarSlots(MODO_EDICION);
        }
    });

    function wireServicios() {
        document.querySelectorAll('.sb-servicio-chip').forEach(function (btn) {
            if (parseInt(btn.dataset.id) === st.servicioId) {
                btn.classList.add('selected');
            }
            btn.addEventListener('click', function () {
                st.servicioId       = parseInt(this.dataset.id);
                st.servicioNombre   = this.dataset.nombre;
                st.servicioPrecio   = parseFloat(this.dataset.precio);
                st.servicioDuracion = parseInt(this.dataset.duracion);
                st.hora = null;
                document.querySelectorAll('.sb-servicio-chip').forEach(function (b) {
                    b.classList.remove('selected');
                });
                this.classList.add('selected');
                actualizarHiddens();
                actualizarBarra();
                cargarSlots();
            });
        });
    }

    function wirePeluqueros() {
        document.querySelectorAll('.sb-peluquero-card').forEach(function (btn) {
            if (parseInt(btn.dataset.id) === st.peluqueroId) {
                btn.classList.add('selected');
            }
            btn.addEventListener('click', function () {
                st.peluqueroId     = parseInt(this.dataset.id);
                st.peluqueroNombre = this.dataset.nombre;
                st.hora = null;
                document.querySelectorAll('.sb-peluquero-card').forEach(function (b) {
                    b.classList.remove('selected');
                });
                this.classList.add('selected');
                actualizarHiddens();
                actualizarBarra();
                cargarSlots();
            });
        });
    }

    function generarCalendario() {
        var hoy   = hoyLocal();
        var dow   = hoy.getDay();
        var diffL = dow === 0 ? -6 : 1 - dow;
        var lunes = new Date(hoy);
        lunes.setDate(lunes.getDate() + diffL + st.semanaOffset * 7);

        var cal = document.getElementById('cal-semana');
        cal.innerHTML = '';
        var primerD, ultimoD;

        for (var i = 0; i < 7; i++) {
            var d      = new Date(lunes.getFullYear(), lunes.getMonth(), lunes.getDate() + i);
            var fs     = toDateStr(d);
            var desact = (d.getDay() === 0) || (d < hoy);
            var esHoy  = fs === toDateStr(hoy);
            if (i === 0) primerD = d;
            ultimoD = d;

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'sb-cal-dia' +
                (desact        ? ' disabled'  : '') +
                (fs === st.fecha ? ' selected' : '') +
                (esHoy && fs !== st.fecha && !desact ? ' hoy' : '');
            btn.disabled     = desact;
            btn.dataset.fecha = fs;
            btn.innerHTML =
                '<span class="dia-nombre">' + DIAS_CORTO[(d.getDay() + 6) % 7] + '</span>' +
                '<span class="dia-num">'    + d.getDate()             + '</span>' +
                '<span class="dia-mes">'    + MESES[d.getMonth()]     + '</span>';

            if (!desact) {
                btn.addEventListener('click', function () {
                    st.fecha        = this.dataset.fecha;
                    st.fechaDisplay = formatFecha(st.fecha);
                    st.hora         = null;
                    var hoyStr = toDateStr(hoyLocal());
                    cal.querySelectorAll('.sb-cal-dia').forEach(function (b) {
                        b.classList.remove('selected');
                        if (!b.disabled && b.dataset.fecha === hoyStr) b.classList.add('hoy');
                        else b.classList.remove('hoy');
                    });
                    this.classList.add('selected');
                    this.classList.remove('hoy');
                    actualizarHiddens();
                    actualizarBarra();
                    cargarSlots();
                });
            }
            cal.appendChild(btn);
        }

        document.getElementById('rango-semana').textContent =
            primerD.getDate() + '–' + ultimoD.getDate() + ' ' + MESES[ultimoD.getMonth()];

        document.getElementById('btn-semana-ant').disabled = st.semanaOffset <= 0;
        document.getElementById('btn-semana-sig').disabled = st.semanaOffset >= 4;

        document.getElementById('btn-semana-ant').onclick = function () {
            if (st.semanaOffset > 0) { st.semanaOffset--; generarCalendario(); }
        };
        document.getElementById('btn-semana-sig').onclick = function () {
            if (st.semanaOffset < 4) { st.semanaOffset++; generarCalendario(); }
        };
    }

    async function cargarSlots(preservarHora) {
        if (!st.fecha || !st.peluqueroId || !st.servicioId) return;

        var horaAnt = st.hora;
        st.hora = null;

        var box = document.getElementById('slots-container');
        box.innerHTML =
            '<div class="sb-slots-loading">' +
            '<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>' +
            ' Comprobando disponibilidad…</div>';

        try {
            var params = new URLSearchParams({
                fecha:        st.fecha,
                id_peluquero: st.peluqueroId,
                id_servicio:  st.servicioId,
            });
            if (CITA_ID) params.set('excluir_cita', CITA_ID);

            var res  = await fetch(URL_DISP + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            var data  = await res.json();
            var slots = data.slots || [];

            renderSlots(slots, box);

            if (preservarHora && horaAnt) {
                var match = slots.find(function (s) { return s.hora === horaAnt && s.disponible; });
                if (match) {
                    st.hora = horaAnt;
                    var hBtn = box.querySelector('[data-hora="' + horaAnt + '"]');
                    if (hBtn) hBtn.classList.add('selected');
                }
            }
        } catch (e) {
            box.innerHTML =
                '<div style="color:#DC2626;font-size:13.5px;padding:12px 0;">' +
                'Error al cargar disponibilidad. Recarga la página.</div>';
        }

        actualizarHiddens();
        actualizarBarra();
    }

    function renderSlots(slots, box) {
        if (!slots.length) {
            box.innerHTML =
                '<div style="padding:20px 0;text-align:center;color:#9CA3AF;font-size:14px;">' +
                '<i class="bi bi-calendar-x" style="font-size:28px;display:block;margin-bottom:8px;"></i>' +
                'No hay horas disponibles para ese día. Prueba con otra fecha.</div>';
            return;
        }

        var man = slots.filter(function (s) { return s.hora < '14:00'; });
        var tar = slots.filter(function (s) { return s.hora >= '14:00'; });
        var html = '';

        if (man.length) {
            html += '<div class="sb-slots-label"><i class="bi bi-sunrise me-1"></i>Mañana</div>' +
                    '<div class="sb-slots-grid">';
            man.forEach(function (s) { html += mkSlot(s); });
            html += '</div>';
        }
        if (tar.length) {
            html += '<div class="sb-slots-label" style="margin-top:20px;"><i class="bi bi-sunset me-1"></i>Tarde</div>' +
                    '<div class="sb-slots-grid">';
            tar.forEach(function (s) { html += mkSlot(s); });
            html += '</div>';
        }
        box.innerHTML = html;

        box.querySelectorAll('.sb-slot:not(.ocupado)').forEach(function (btn) {
            btn.addEventListener('click', function () {
                st.hora = this.dataset.hora;
                box.querySelectorAll('.sb-slot').forEach(function (b) { b.classList.remove('selected'); });
                this.classList.add('selected');
                actualizarHiddens();
                actualizarBarra();
            });
        });
    }

    function mkSlot(s) {
        return '<button type="button" class="sb-slot' + (s.disponible ? '' : ' ocupado') + '"' +
               (s.disponible ? '' : ' disabled') +
               ' data-hora="' + s.hora + '">' + s.hora + '</button>';
    }

    function actualizarHiddens() {
        document.getElementById('input-servicio').value  = st.servicioId  || '';
        document.getElementById('input-peluquero').value = st.peluqueroId || '';
        document.getElementById('input-fecha').value     = st.fecha       || '';
        document.getElementById('input-hora').value      = st.hora        || '';
    }

    function actualizarBarra() {
        var ok = !!(st.servicioId && st.peluqueroId && st.fecha && st.hora);
        document.getElementById('botones-confirmar').style.display = ok ? 'flex' : 'none';
    }

    function hoyLocal() {
        var d = new Date(); d.setHours(0, 0, 0, 0); return d;
    }
    function toDateStr(d) {
        return d.getFullYear() + '-' +
               String(d.getMonth() + 1).padStart(2, '0') + '-' +
               String(d.getDate()).padStart(2, '0');
    }
    function parseLocalDate(str) {
        var p = str.split('-').map(Number);
        return new Date(p[0], p[1] - 1, p[2]);
    }
    function formatFecha(str) {
        var d = parseLocalDate(str);
        return DIAS_LARGO[d.getDay()] + ', ' + d.getDate() + ' ' + MESES[d.getMonth()];
    }
})();
</script>
@endpush
