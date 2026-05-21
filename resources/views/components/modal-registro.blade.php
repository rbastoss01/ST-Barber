<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:480px;">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15);">

            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="modalRegistroLabel" style="font-size:20px;color:#111;">
                        Crear cuenta
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size:13.5px;">
                        Regístrate y reserva tu próxima cita online
                    </p>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body px-4 py-3">

                @if($errors->any() && old('_form_type') === 'registro')
                    <div id="registro-error-alert" class="alert alert-danger d-flex align-items-start gap-2 mb-3 py-2 px-3" style="border-radius:10px;font-size:13px;border:none;background:#FEF2F2;color:#991B1B;">
                        <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <input type="hidden" name="_form_type" value="registro">

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="regNombre" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                                Nombre 
                                <span style="color:#EF4444;">*</span>
                            </label>
                            <input type="text" id="regNombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Carlos" value="{{ old('nombre') }}" autocomplete="given-name" required style="border-color:#E9ECEF;border-radius:8px;">
                        </div>
                        <div class="col-6">
                            <label for="regApellidos" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                                Apellidos 
                                <span style="color:#EF4444;">*</span>
                            </label>
                            <input type="text" id="regApellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" placeholder="García López" value="{{ old('apellidos') }}" autocomplete="family-name" required style="border-color:#E9ECEF;border-radius:8px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regEmail" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Correo electrónico 
                            <span style="color:#EF4444;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-envelope text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="email" id="regEmail" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" placeholder="tu@email.com" value="{{ old('email') }}" autocomplete="email" required style="border-color:#E9ECEF;border-radius:0 8px 8px 0;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regTelefono" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Teléfono
                            <span class="text-muted fw-normal" style="font-size:12px;">(opcional)</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-phone text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="tel" id="regTelefono" name="telefono" class="form-control border-start-0 ps-0 @error('telefono') is-invalid @enderror" placeholder="600 000 000" value="{{ old('telefono') }}"  autocomplete="tel" style="border-color:#E9ECEF;border-radius:0 8px 8px 0;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regPassword" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Contraseña <span style="color:#EF4444;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-lock text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="password" id="regPassword" name="password" class="form-control border-start-0 ps-0 border-end-0 @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" autocomplete="new-password" required style="border-color:#E9ECEF;">
                            <button type="button"  class="input-group-text bg-white border-start-0" style="border-color:#E9ECEF;border-radius:0 8px 8px 0;cursor:pointer;" onclick="togglePasswordVisibility('regPassword', this)">
                                <i class="bi bi-eye text-muted" style="font-size:15px;"></i>
                            </button>
                        </div>
                        <div style="font-size:11.5px;color:#9CA3AF;margin-top:4px;">
                            Usa al menos 8 caracteres
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="regPasswordConfirm" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Confirmar contraseña <span style="color:#EF4444;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-lock-fill text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="password" id="regPasswordConfirm" name="password_confirmation" class="form-control border-start-0 ps-0 border-end-0" placeholder="Repite la contraseña" autocomplete="new-password" required style="border-color:#E9ECEF;">
                            <button type="button" class="input-group-text bg-white border-start-0" style="border-color:#E9ECEF;border-radius:0 8px 8px 0;cursor:pointer;" onclick="togglePasswordVisibility('regPasswordConfirm', this)">
                                <i class="bi bi-eye text-muted" style="font-size:15px;"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100" style="background:#111111;color:#fff;border-radius:10px;padding:11px;font-size:14px;font-weight:600;border:none;transition:background .2s;" onmouseout="this.style.background='#111111'">
                        Crear cuenta
                    </button>
                </form>

                <div class="d-flex align-items-center gap-3 my-4">
                    <hr class="flex-grow-1 my-0" style="border-color:#E9ECEF;">
                    <span style="font-size:12px;color:#9CA3AF;white-space:nowrap;">¿Ya tienes cuenta?</span>
                    <hr class="flex-grow-1 my-0" style="border-color:#E9ECEF;">
                </div>

                <button type="button" id="switchToLogin" class="btn w-100" style="background:#F3F4F6;color:#374151;border-radius:10px;padding:11px;font-size:14px;font-weight:600;border:none;transition:background .2s;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                    Iniciar sesión
                </button>
            </div>

            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <p class="text-muted mb-0 mx-auto" style="font-size:11.5px;">
                    Al registrarte aceptas nuestros
                    <a href="#" style="color:#111111;text-decoration:none;">términos de uso</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btnSwitch    = document.getElementById('switchToLogin');
        var modalLogin   = document.getElementById('modalLogin');
        var modalRegistro = document.getElementById('modalRegistro');

        if (btnSwitch && modalLogin && modalRegistro) {
            btnSwitch.addEventListener('click', function () {
                var regInst = bootstrap.Modal.getInstance(modalRegistro);
                regInst?.hide();
                modalRegistro.addEventListener('hidden.bs.modal', function onHidden() {
                    new bootstrap.Modal(modalLogin).show();
                    modalRegistro.removeEventListener('hidden.bs.modal', onHidden);
                });
            });
        }
    });
</script>
