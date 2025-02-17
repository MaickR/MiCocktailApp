@extends('layouts.app')

<style>
    /* ====== Título de la sección ====== */
    .search-heading {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        text-align: center;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* ====== Estilos para inputs y selects de búsqueda ====== */
    .search-container .form-control,
    .search-container .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    
    .search-container .form-control:focus,
    .search-container .form-select:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        border-color: #2563eb;
    }
    
    /* Botones de buscar y limpiar */
    .search-container .btn-search {
        background: linear-gradient(45deg, #2563eb, #1e40af);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .search-container .btn-search:hover {
        background: linear-gradient(45deg, #dc3545, #e63946);
        transform: translateY(-2px);
    }
    
    .search-container .btn-clear {
        background-color: #6c757d;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .search-container .btn-clear:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
    
    /* ====== Cards (Mismo estilo que en home) ====== */
    .cocktail-col {
        display: flex;
        align-items: stretch; 
    }
    
    .cocktail-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column; 
        width: 100%;
    }
    
    .cocktail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .cocktail-card-img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        object-position: center;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        background-color: #fff;
    }
    
    .cocktail-card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
    }
    
    .cocktail-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .cocktail-info {
        font-size: 0.9rem;
        color: #4b5563;
        margin-bottom: 0.25rem;
    }
    
    /* Botón de favoritos con gradiente y hover rojo */
    .btn-fav {

        box-shadow:inset -1px 0px 50px 50px #f7f5f5d5;
	background:linear-gradient(to bottom, #fe1a00 5%, #da2020 100%);
	background-color:#f54935;
	border-radius:16px;
	border:2px solid #d83526;
	display:inline-block;
	cursor:pointer;
	color:#dd1e44 !important;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:4px 30px;
	text-decoration:none;

        transition: all 0.3s ease;
        font-weight: 600;
        padding: 0.75rem;
    }
    
    .btn-fav i {
        margin-right: 8px;
    }
    
    .btn-fav:hover {
    background:linear-gradient(to bottom, #dd5959 5%, #fe1a00 100%);
	background-color:#ce0100 ;
    color: #e03859 !important;
    transform: translateY(-2px);
    }
    
    /* ====== Botones de paginación (Siguiente/Anterior) ====== */
    #btn-prev, #btn-next {
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-weight: 600;
    }
    
    #btn-prev:hover, #btn-next:hover {
        background-color: #e0e7ff;
        transform: translateY(-2px);
    }
    
    /* Ajustar el contenedor de resultados */
    #search-results {
        margin-top: 2rem;
    }
    </style>

@section('content')
<div class="container search-container">
    <h1 class="search-heading">Buscar Cócteles</h1>
    <p class="text-muted text-center">Solo puede utilizar un filtro a la vez. Si ingresa un filtro, los demás se limpiarán.</p>

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="search-name" class="form-label fw-semibold">Nombre</label>
            <input type="text" id="search-name" class="form-control" placeholder="Ej: Margarita">
        </div>
        <div class="col-md-4">
            <label for="search-category" class="form-label fw-semibold">Categoría</label>
            <select id="search-category" class="form-select">
                <option value="">-- Seleccionar --</option>
                <option value="Ordinary_Drink">Ordinary Drink</option>
                <option value="Cocktail">Cocktail</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="search-type" class="form-label fw-semibold">Tipo</label>
            <select id="search-type" class="form-select">
                <option value="">-- Seleccionar --</option>
                <option value="Alcoholic">Alcoholic</option>
                <option value="Non_Alcoholic">Non alcoholic</option>
            </select>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 d-flex align-items-end">
            <button id="btn-search" class="btn btn-search me-2">
                <i class="bi bi-search"></i> Buscar
            </button>
            <button id="btn-clear" class="btn btn-clear">
                <i class="bi bi-x-circle"></i> Limpiar Filtros
            </button>
        </div>
    </div>

    <!-- Contenedor de resultados -->
    <div class="row" id="search-results"></div>

    <!-- Contenedor para los botones de paginación -->
    <div class="row mt-3">
        <div class="col text-center">
            <button id="btn-prev" class="btn btn-outline-primary me-2">Anterior</button>
            <button id="btn-next" class="btn btn-outline-primary">Siguiente</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('home_scripts')

<script>
$(document).ready(function(){
    let currentPage = 1; // Página actual

    // Cuando se escribe en el campo nombre, limpiar los selects
    $('#search-name').on('input', function(){
        $('#search-category').val('');
        $('#search-type').val('');
    });

    // Cuando se selecciona en los selects, limpiar el campo de nombre
    $('#search-category, #search-type').on('change', function(){
        $('#search-name').val('');
    });

    // Botón "Limpiar Filtros"
    $('#btn-clear').click(function(){
        clearFilters();
    });

    // Botón "Buscar"
    $('#btn-search').click(function(){
        currentPage = 1; // Reiniciamos a la primera página
        doSearch();
    });

    // Botones de paginación
    $('#btn-prev').click(function(){
        if(currentPage > 1) {
            currentPage--;
            doSearch();
        }
    });
    $('#btn-next').click(function(){
        currentPage++;
        doSearch();
    });

    // Función para limpiar filtros y resultados
    function clearFilters() {
        $('#search-name').val('');
        $('#search-category').val('');
        $('#search-type').val('');
        $('#search-results').html('');
        currentPage = 1;
    }

    // Función principal de búsqueda
    function doSearch() {
        let name = $('#search-name').val().trim();
        let category = $('#search-category').val();
        let type = $('#search-type').val();

        // Contar cuántos filtros
        let filtersUsed = 0;
        if(name) filtersUsed++;
        if(category) filtersUsed++;
        if(type) filtersUsed++;

        // Si no hay filtros
        if(filtersUsed === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: 'Por favor, ingrese un filtro para buscar.',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }

        // Si hay más de un filtro
        if(filtersUsed > 1){
            Swal.fire({
                icon: 'warning',
                title: 'Solo un filtro a la vez',
                text: 'Por favor, seleccione únicamente un filtro.',
            });
            return;
        }

        // Mostrar "Buscando..."
        Swal.fire({
            title: 'Buscando...',
            text: 'Por favor espere un momento.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Construir los parámetros para AJAX
        let params = {
            page: currentPage
        };
        if(name) {
            params.name = name;
        } else if(category) {
            params.category = category;
        } else if(type) {
            params.type = type;
        }

        // Llamada AJAX
        $.ajax({
            url: "{{ route('search.ajax') }}",
            method: 'GET',
            data: params,
            success: function(response){
                Swal.close();
                renderResults(response);
            },
            error: function(xhr){
                Swal.close();
                $('#search-results').html('<p class="text-danger">Error en la búsqueda.</p>');
            }
        });
    }

    // Función para mostrar los resultados
    function renderResults(response) {
        let cocktails = response.cocktails || [];
        let totalPages = response.totalPages || 1;
        currentPage = response.currentPage || 1;

        if(!Array.isArray(cocktails) || cocktails.length === 0) {
            $('#search-results').html('<p>No se encontraron resultados.</p>');
            return;
        }

        // Generar el HTML de cada cóctel
        let html = '';
        cocktails.forEach(function(cocktail){
            html += `
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="${cocktail.strDrinkThumb}" class="card-img-top" alt="${cocktail.strDrink}">
                    <div class="card-body">
                        <h5 class="card-title">${cocktail.strDrink}</h5>
                        <p><strong>Categoría:</strong> ${cocktail.strCategory || 'N/A'}</p>
                        <p><strong>Tipo:</strong> ${cocktail.strAlcoholic || 'N/A'}</p>
                        <p><strong>Instrucciones:</strong> ${cocktail.strInstructions || 'N/A'}</p>
                        <button class="btn btn-outline-danger btn-fav"
                            data-cocktail_id_api="${cocktail.idDrink}"
                            data-name="${cocktail.strDrink}"
                            data-thumbnail="${cocktail.strDrinkThumb}">
                            <i class="bi bi-heart"></i> Agregar a Favoritos
                        </button>
                    </div>
                </div>
            </div>
            `;
        });
        $('#search-results').html(html);

        // Habilitar/Deshabilitar botones de paginación
        if(currentPage <= 1) {
            $('#btn-prev').prop('disabled', true);
        } else {
            $('#btn-prev').prop('disabled', false);
        }
        if(currentPage >= totalPages) {
            $('#btn-next').prop('disabled', true);
        } else {
            $('#btn-next').prop('disabled', false);
        }

        // Re-asignar evento "Agregar a Favoritos"
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
                success: function(resp){
                    Swal.fire({
                        icon: 'success',
                        title: resp.success,
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
    }
});
</script>
@endsection
