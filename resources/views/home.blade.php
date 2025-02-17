@extends('layouts.app')


<style>
/* ====== Título con animación flotante ====== */
.home-heading {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin-bottom: 2rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* ====== Ajustes del contenedor de Cards ====== */
/* Asegura que cada card ocupe toda la altura disponible en su col */
.cocktail-col {
    display: flex;
    align-items: stretch; /* Estira las cards a la misma altura */
}

/* ====== Cards de Cócteles ====== */
.cocktail-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column; 
    width: 100%;  /* Para ocupar todo el espacio de la col */
}

.cocktail-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Imagen: se ve completa con object-fit: contain */
.cocktail-card-img {
    width: 100%;
    height: 220px; 
    object-fit: contain; 
    object-position: center;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    background-color: #fff;
}

/* Contenedor del texto y botón */
.cocktail-card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Para empujar el botón al final */
    padding: 1rem;
}

/* Título del cóctel */
.cocktail-card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Texto general de info */
.cocktail-info {
    font-size: 0.9rem;
    color: #4b5563;
    margin-bottom: 0.25rem;
}

/* Botón de favoritos */
.btn-fav {
    width: 100%;
    /* Gradiente rojo */
    background: linear-gradient(45deg, #ec707a, #f06270);
    color: #fff;
    border: none;
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem;
    box-shadow: 0 4px 10px rgba(220,53,69,0.2);
}

.btn-fav i {
    margin-right: 8px;
}

/* Hover en el botón (rojo) */
.btn-fav:hover {
    background: linear-gradient(45deg, #dc3545, #e63946);
    box-shadow: 0 8px 20px rgba(220,53,69,0.3);
    transform: translateY(-2px);
}

/* ====== Paginación ====== */
.pagination {
    justify-content: center; 
    margin-top: 2rem;
}

.pagination .page-item .page-link {
    color: #2563eb;
    border-radius: 8px;
    margin: 0 2px;
    border: 1px solid #ddd;
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background-color: #2563eb;
    border-color: #2563eb;
    color: #fff;
}

.pagination .page-link:hover {
    background-color: #e0e7ff;
    color: #2563eb;
}

</style>


@section('content')
<h1 class="mb-4 home-heading">Listado de Cócteles</h1>

<div class="row">
    @forelse($cocktails as $cocktail)
        <!-- col-md-4 + cocktail-col para alinear las cards a la misma altura -->
        <div class="col-md-4 mb-4 cocktail-col">
            <div class="cocktail-card">
                <img src="{{ $cocktail['strDrinkThumb'] }}" class="cocktail-card-img" alt="{{ $cocktail['strDrink'] }}">
                <div class="cocktail-card-body">
                    <h5 class="cocktail-card-title">{{ $cocktail['strDrink'] }}</h5>
                    <p class="cocktail-info"><strong>Categoría:</strong> {{ $cocktail['strCategory'] }}</p>
                    <p class="cocktail-info"><strong>Tipo:</strong> {{ $cocktail['strAlcoholic'] }}</p>
                    <p class="cocktail-info"><strong>Instrucciones:</strong> {{ $cocktail['strInstructions'] }}</p>

                    <button class="btn btn-fav" 
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

{{-- Paginación --}}
@if($totalPages > 1)
    <nav aria-label="Paginación de cócteles">
        <ul class="pagination">
            {{-- Botón "Anterior" --}}
            @if($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ route('home', ['page' => $currentPage - 1]) }}">
                        Anterior
                    </a>
                </li>
            @endif

            {{-- Números de página --}}
            @for($i = 1; $i <= $totalPages; $i++)
                <li class="page-item @if($i == $currentPage) active @endif">
                    <a class="page-link" href="{{ route('home', ['page' => $i]) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            {{-- Botón "Siguiente" --}}
            @if($currentPage < $totalPages)
                <li class="page-item">
                    <a class="page-link" href="{{ route('home', ['page' => $currentPage + 1]) }}">
                        Siguiente
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function(){
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
