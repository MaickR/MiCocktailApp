<!-- resources/views/profile/partials/update-profile-information-form.blade.php -->
<form id="profile-info-form" method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-4">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="name"
               value="{{ old('name', $user->name) }}"
               required
               minlength="4"
               maxlength="10">
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email"
               value="{{ old('email', $user->email) }}"
               required>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-start">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-2"></i>Guardar Cambios
        </button>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function() {
    const $form = $('#profile-info-form');

    // Al enviar, validación extra en JS (opcional)
    $form.on('submit', function(e){
        e.preventDefault();
        const $name  = $('#name');
        const $email = $('#email');
        let errors = [];

        if ($name.val().trim().length < 4 || $name.val().trim().length > 10) {
            errors.push('El nombre debe tener entre 4 y 10 caracteres');
        }

        // Validación simple de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test($email.val())) {
            errors.push('Ingresa un correo electrónico válido');
        }

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                html: errors.join('<br>'),
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        // Enviar el form
        $form.off('submit').submit();
    });

    // Si hay errores del servidor (por duplicados), los mostramos con SweetAlert
    var errors = <?php echo json_encode($errors->all()); ?>;
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error del Servidor',
            html: errors.join('<br>')
        });
    }

    // Mensaje de éxito si se actualizó
    var status = "{{ session('status') }}";
    if (status === 'perfil-actualizado') {
        Swal.fire({
            icon: 'success',
            title: '¡Cambios guardados!',
            text: 'Tu perfil se ha actualizado correctamente',
            confirmButtonColor: '#2563eb',
            timer: 3000
        });
    }
});
</script>
@endpush
