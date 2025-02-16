@extends('layouts.app')

@section('content')
<h1 class="mb-4">Buscar Cócteles</h1>
<form method="GET" action="{{ route('search') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="Buscar cóctel..." required>
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
    </div>
</form>

@if(isset($results))
    <div class="row">
        @forelse($results as $cocktail)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ $cocktail['strDrinkThumb'] }}" class="card-img-top" alt="{{ $cocktail['strDrink'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $cocktail['strDrink'] }}</h5>
                    <!-- Botón para agregar a favoritos (similar a Home) -->
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
            <p>No se encontraron resultados.</p>
        @endforelse
    </div>
@endif
@endsection

@section('scripts')
@include('home_scripts') {{-- Reutilizamos el script para favoritos --}}
@endsection
