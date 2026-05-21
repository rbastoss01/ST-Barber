<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15);">

            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="modalLoginLabel"  style="font-size:20px;color:#111;">
                        Iniciar sesión
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size:13.5px;">
                        Bienvenido de nuevo a ST BARBER
                    </p>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body px-4 py-3">

                <form method="POST" action="{{ route('login') }}" novalidate id="formLogin">
                    @csrf
                    <input type="hidden" name="_form_type" value="login">

                    <div class="mb-3">
                        <label for="loginEmail" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Correo electrónico
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-envelope text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="email" id="loginEmail" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" placeholder="tu@email.com" value="{{ old('email') }}" autocomplete="email" required style="border-color:#E9ECEF;border-radius:0 8px 8px 0;">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label for="loginPassword" class="form-label" style="font-size:13px;font-weight:600;color:#374151;">
                            Contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-color:#E9ECEF;border-radius:8px 0 0 8px;">
                                <i class="bi bi-lock text-muted" style="font-size:15px;"></i>
                            </span>
                            <input type="password" id="loginPassword" name="password" class="form-control border-start-0 ps-0 border-end-0 @error('password') is-invalid @enderror" placeholder="Tu contraseña" autocomplete="current-password" required style="border-color:#E9ECEF;">
                            <button type="button" class="input-group-text bg-white border-start-0" style="border-color:#E9ECEF;border-radius:0 8px 8px 0;cursor:pointer;" onclick="togglePasswordVisibility('loginPassword', this)">
                                <i class="bi bi-eye text-muted" style="font-size:15px;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-end mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size:12.5px;color:#111111;font-weight:500;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    @if($errors->has('login'))
                        <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:13px;">
                            {{ $errors->first('login') }}
                        </div>
                    @endif

                    <button type="submit" class="btn w-100 fw-600" style="background:#111111;color:#fff;border-radius:10px;padding:11px;font-size:14px;font-weight:600;border:none;transition:background .2s;" onmouseover="this.style.background='#333333'" onmouseout="this.style.background='#111111'">
                        Iniciar sesión
                    </button>
                </form>

                <div class="d-flex align-items-center gap-3 my-4">
                    <hr class="flex-grow-1 my-0" style="border-color:#E9ECEF;">
                    <span style="font-size:12px;color:#9CA3AF;white-space:nowrap;">¿Aún no tienes cuenta?</span>
                    <hr class="flex-grow-1 my-0" style="border-color:#E9ECEF;">
                </div>

                <button type="button" id="switchToRegistro" class="btn w-100" style="background:#F3F4F6;color:#374151;border-radius:10px;padding:11px;font-size:14px;font-weight:600;border:none;transition:background .2s;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                    Crear una cuenta nueva
                </button>
            </div>

            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <p class="text-muted mb-0 mx-auto" style="font-size:11.5px;">
                    Al iniciar sesión aceptas nuestros
                    <a href="#" style="color:#111111;text-decoration:none;">términos de uso</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        function togglePasswordVisibility(inputId, btn) {
            var input = document.getElementById(inputId);
            var icon  = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash text-muted';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye text-muted';
            }
        }
        window.togglePasswordVisibility = togglePasswordVisibility;

        document.addEventListener('DOMContentLoaded', function () {
            var modalLoginEl  = document.getElementById('modalLogin');
            var modalRegistroEl = document.getElementById('modalRegistro');
            var btnSwitch     = document.getElementById('switchToRegistro');

            if (btnSwitch && modalLoginEl && modalRegistroEl) {
                btnSwitch.addEventListener('click', function () {
                    var loginInst = bootstrap.Modal.getInstance(modalLoginEl);
                    loginInst?.hide();
                    modalLoginEl.addEventListener('hidden.bs.modal', function onHidden() {
                        new bootstrap.Modal(modalRegistroEl).show();
                        modalLoginEl.removeEventListener('hidden.bs.modal', onHidden);
                    });
                });
            }
        });
    })();
</script>
