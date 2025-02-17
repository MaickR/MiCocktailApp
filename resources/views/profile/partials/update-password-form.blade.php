@php
    // Leemos errores y status fuera del script
    $passwordErrors = $errors->all(); 
    $passwordStatus = session('status');
@endphp

<form id="form-password" method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label">Contraseña Actual</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
        @error('current_password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nueva Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>

        <!-- Indicador de requisitos -->
        <div id="password-requirements" class="mt-2 text-muted">
            <ul class="list-unstyled mb-0">
                <li id="req-length" class="text-danger">
                    <i class="bi bi-x-circle-fill me-1"></i> Mínimo 4 caracteres
                </li>
                <li id="req-uppercase" class="text-danger">
                    <i class="bi bi-x-circle-fill me-1"></i> Al menos 1 mayúscula
                </li>
                <li id="req-number" class="text-danger">
                    <i class="bi bi-x-circle-fill me-1"></i> Al menos 1 dígito
                </li>
                <li id="req-special" class="text-danger">
                    <i class="bi bi-x-circle-fill me-1"></i> Al menos 1 carácter especial
                </li>
            </ul>
        </div>

        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>

    <!-- Botón a la izquierda -->
    <div class="d-flex justify-content-start">
        <button type="submit" class="btn btn-primary" id="btn-password-save">
            Cambiar Contraseña
        </button>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function(){
    // 1) Validaciones en tiempo real
    const $formPass      = $('#form-password');
    const $passwordField = $('#password');
    const $reqLength     = $('#req-length');
    const $reqUppercase  = $('#req-uppercase');
    const $reqNumber     = $('#req-number');
    const $reqSpecial    = $('#req-special');
    const $passConfirm   = $('#password_confirmation');

    // Actualizar los requisitos en tiempo real
    $passwordField.on('input', function(){
        let val = $(this).val();

        // Mínimo 4
        if (val.length >= 4) {
            $reqLength.removeClass('text-danger').addClass('text-success')
                      .html(`<i class="bi bi-check-circle-fill me-1"></i> Mínimo 4 caracteres`);
        } else {
            $reqLength.removeClass('text-success').addClass('text-danger')
                      .html(`<i class="bi bi-x-circle-fill me-1"></i> Mínimo 4 caracteres`);
        }

        // 1 mayúscula
        if (/[A-Z]/.test(val)) {
            $reqUppercase.removeClass('text-danger').addClass('text-success')
                         .html(`<i class="bi bi-check-circle-fill me-1"></i> Al menos 1 mayúscula`);
        } else {
            $reqUppercase.removeClass('text-success').addClass('text-danger')
                         .html(`<i class="bi bi-x-circle-fill me-1"></i> Al menos 1 mayúscula`);
        }

        // 1 dígito
        if (/[0-9]/.test(val)) {
            $reqNumber.removeClass('text-danger').addClass('text-success')
                      .html(`<i class="bi bi-check-circle-fill me-1"></i> Al menos 1 dígito`);
        } else {
            $reqNumber.removeClass('text-success').addClass('text-danger')
                      .html(`<i class="bi bi-x-circle-fill me-1"></i> Al menos 1 dígito`);
        }

        // 1 caracter especial
        if (/[\W_]/.test(val)) {
            $reqSpecial.removeClass('text-danger').addClass('text-success')
                       .html(`<i class="bi bi-check-circle-fill me-1"></i> Al menos 1 carácter especial`);
        } else {
            $reqSpecial.removeClass('text-success').addClass('text-danger')
                       .html(`<i class="bi bi-x-circle-fill me-1"></i> Al menos 1 carácter especial`);
        }
    });

    // 2) Verificar contraseñas al enviar
    $formPass.on('submit', function(e){
        let pass        = $passwordField.val();
        let passConfirm = $passConfirm.val();

        if (pass !== passConfirm) {
            e.preventDefault();
            alert("Las contraseñas no coinciden.");
        }
    });

});
</script>
@endpush
{{-- # --}}