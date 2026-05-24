@extends('layouts.app')

@section('title', 'Nueva contraseña — ST BARBER')

@section('content')

<div style="min-height:80vh; display:flex; align-items:center; background:#F5F5F5; padding:40px 16px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4">

                <div class="text-center mb-4">
                    <a href="{{ route('inicio') }}"
                       style="font-size:13px;font-weight:800;letter-spacing:5px;color:#1A1A1A;text-decoration:none;text-transform:uppercase;">
                        ST BARBER
                    </a>
                    <h1 style="font-size:22px;font-weight:800;color:#111;margin-top:20px;margin-bottom:6px;">
                        Crear nueva contraseña
                    </h1>
                    <p style="font-size:14px;color:#6B7280;margin:0;">
                        Elige una contraseña segura para tu cuenta.
                    </p>
                </div>

                <div style="background:#fff;border:1px solid #E9ECEF;border-radius:16px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.05);">
                    @if($errors->any())
                        <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;">
                            <i class="bi bi-exclamation-circle-fill" style="color:#DC2626;font-size:16px;margin-top:1px;flex-shrink:0;"></i>
                            <div style="font-size:13.5px;color:#991B1B;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div style="margin-bottom:18px;">
                            <label for="email" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                                Correo electrónico
                            </label>
                            <div style="display:flex;align-items:center;border:1.5px solid {{ $errors->has('email') ? '#EF4444' : '#E9ECEF' }};border-radius:9px;overflow:hidden;background:#F9FAFB;" onfocusin="this.style.borderColor='#111111';this.style.background='#fff'" onfocusout="this.style.borderColor='{{ $errors->has('email') ? '#EF4444' : '#E9ECEF' }}';this.style.background='#F9FAFB'">
                                <span style="padding:0 12px;color:#9CA3AF;font-size:15px;">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email', $email) }}"  placeholder="tu@email.com" autocomplete="email" required style="flex:1;border:none;outline:none;padding:11px 12px 11px 0;font-size:14px;font-family:'Inter',sans-serif;color:#111;background:transparent;">
                            </div>
                        </div>

                        <div style="margin-bottom:18px;">
                            <label for="password" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                                Nueva contraseña
                            </label>
                            <div id="wrapPassword"
                                 style="display:flex;align-items:center;border:1.5px solid {{ $errors->has('password') ? '#EF4444' : '#E9ECEF' }};border-radius:9px;overflow:hidden;background:#fff;" onfocusin="this.style.borderColor='#111111'" onfocusout="this.style.borderColor='{{ $errors->has('password') ? '#EF4444' : '#E9ECEF' }}'">
                                <span style="padding:0 12px;color:#9CA3AF;font-size:15px;flex-shrink:0;">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password" required style="flex:1;border:none;outline:none;padding:11px 0;font-size:14px;font-family:'Inter',sans-serif;color:#111;background:transparent;">
                                <button type="button" onclick="togglePass('password', this)" style="padding:0 12px;border:none;background:transparent;color:#9CA3AF;cursor:pointer;font-size:15px;flex-shrink:0;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div style="font-size:11.5px;color:#9CA3AF;margin-top:4px;">
                                Mínimo 8 caracteres
                            </div>
                        </div>

                        <div style="margin-bottom:24px;">
                            <label for="password_confirmation" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                                Confirmar contraseña
                            </label>
                            <div style="display:flex;align-items:center;border:1.5px solid #E9ECEF;border-radius:9px;overflow:hidden;background:#fff;" onfocusin="this.style.borderColor='#111111'" onfocusout="this.style.borderColor='#E9ECEF'">
                                <span style="padding:0 12px;color:#9CA3AF;font-size:15px;flex-shrink:0;">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña" autocomplete="new-password" required style="flex:1;border:none;outline:none;padding:11px 0;font-size:14px;font-family:'Inter',sans-serif;color:#111;background:transparent;">
                                <button type="button" onclick="togglePass('password_confirmation', this)" style="padding:0 12px;border:none;background:transparent;color:#9CA3AF;cursor:pointer;font-size:15px;flex-shrink:0;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" style="display:block;width:100%;background:#111111;color:#fff;border:none;border-radius:10px;padding:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:background .2s;" onmouseout="this.style.background='#111111'">
                            Guardar nueva contraseña
                        </button>
                    </form>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('inicio') }}" style="font-size:13.5px;color:#6B7280;text-decoration:none;display:inline-flex;align-items:center;gap:6px;" onmouseout="this.style.color='#6B7280'">
                        <i class="bi bi-arrow-left"></i>
                        Volver al inicio
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePass(inputId, btn) {
        var input = document.getElementById(inputId);
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endpush

@endsection
