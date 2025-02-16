@extends('layouts.app')

@section('content')
<h1 class="mb-4">Listado de Cócteles</h1>
<div class="row">
    @forelse($cocktails as $cocktail)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ $cocktail['strDrinkThumb'] }}" class="card-img-top" alt="{{ $cocktail['strDrink'] }}">
            <div class="card-body">
                <h5 class="card-title">{{ $cocktail['strDrink'] }}</h5>
                
                <button class="btn btn-outline-danger btn-fav" 
                        data-cocktail_id_api="{{ $cocktail['idDrink'] }}" 
                        data-name="{{ $cocktail['strDrink'] }}" 
                        data-thumbnail="{{ $cocktail['strDrinkThumb'] }}">
                    <i class="bi bi-heart"></i> Agregar a Favoritos
                </button>
            </div>
        </div>
    </div>
    @empty
        <p>No se encontraron cócteles.</p>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    //! Manejo del clic para agregar a favoritos
    $('.btn-fav').click(function(){
        let btn = $(this);
        let data = {
            cocktail_id_api: btn.data('cocktail_id_api'),
            name: btn.data('name'),
            thumbnail: btn.data('thumbnail'),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ route('favorite.store') }}",
            method: 'POST',
            data: data,
            success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: response.success,
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error || 'Ocurrió un error.'
                });
            }
        });
    });
});
</script>
@endsection
