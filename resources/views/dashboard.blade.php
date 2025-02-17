@extends('layouts.app')

@section('content')
<h1 class="mb-4">Mis Cócteles Favoritos</h1>
<table id="cocktailsTable" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Tipo</th>
            <th>Instrucciones</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cocktails as $cocktail)
        <tr>
            <td>{{ $cocktail->id }}</td>
            <td>{{ $cocktail->name }}</td>
            <td>{{ $cocktail->category }}</td>
            <td>{{ $cocktail->alcoholic }}</td>
            <td>{{ $cocktail->instructions }}</td>
            <td>
                <a href="{{ route('cocktails.edit', $cocktail->id) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $cocktail->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('#cocktailsTable').DataTable();

    $('.btn-delete').click(function(){
        let cocktailId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/cocktails/' + cocktailId,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response){
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(function(){ location.reload(); }, 1500);
                    },
                    error: function(xhr){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.error || 'Ocurrió un error.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
