<!-- resources/views/profile/partials/delete-user-form.blade.php -->
<form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Una vez eliminada tu cuenta, todos sus datos serán borrados permanentemente.
    </div>

    <div class="mb-3">
        <label for="delete_password" class="form-label">Contraseña Actual</label>
        <input type="password" class="form-control"
               id="delete_password"
               name="password"
               required>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-start">
        <button type="button" id="btn-delete-account"
                class="btn btn-danger cocktail-btn">
            <i class="bi bi-trash3 me-2"></i>Eliminar Cuenta
        </button>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function(){
    const $deleteForm = $('#delete-account-form');

    $('#btn-delete-account').click(function(e){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: '¿Estás seguro?',
            html: `<div class="text-danger">Esta acción no se puede deshacer</div>
                   <small class="text-muted">Para confirmar, escribe "ELIMINAR" en el siguiente campo</small>`,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirmar Eliminación',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if(value !== 'ELIMINAR') {
                    return 'Debes escribir "ELIMINAR" para confirmar';
                }
            }
        }).then((result) => {
            if(result.isConfirmed){
                Swal.fire({
                    title: 'Eliminando...',
                    html: 'Estamos procesando tu solicitud',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        $deleteForm.submit();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Acción revertida',
                    text: 'No se ha eliminado la cuenta.'
                });
            }
        });
    });

    // Si el servidor devolvió un error (contraseña incorrecta)
    @if($errors->has('password'))
        let errorMessages = '';
        @foreach($errors->all() as $error)
            errorMessages += '{{ $error }}<br>';
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            html: errorMessages
        });
    @endif
});
</script>
@endpush
