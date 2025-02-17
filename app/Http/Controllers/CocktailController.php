<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cocktail;

class CocktailController extends Controller
{
   //* Muestra el listado de cócteles obtenidos de la API.
   public function index(Request $request)
   {
       // Determinar la página actual (por defecto, 1)
       $page = $request->get('page', 1);

       // Si la lista de cócteles no está en sesión, la descargamos
       if (!session()->has('all_cocktails')) {
           // 1. Llamada a filter.php para obtener TODOS los cócteles de la categoría "Cocktail"
           $response = Http::withOptions(['verify' => false])
               ->get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail');

           $all = $response->successful()
               ? $response->json()['drinks'] ?? []
               : [];

           // Guardamos todo en sesión
           session(['all_cocktails' => $all]);
       }

       // Recuperar la lista completa desde la sesión
       $allCocktails = session('all_cocktails', []);

       // 2. Dividir en chunks de 12
       $chunks = array_chunk($allCocktails, 12);
       $totalPages = count($chunks);

       // Control de límites (por si el usuario pone page=99)
       if ($page < 1) {
           $page = 1;
       }
       if ($page > $totalPages) {
           $page = $totalPages;
       }

       // 3. Seleccionar los cócteles de la página actual
       $cocktailsPage = $chunks[$page - 1] ?? [];

       // 4. Para cada cóctel en esta página, llamar a lookup.php y obtener más detalles
       $detailedCocktails = [];
       foreach ($cocktailsPage as $cocktail) {
           $idDrink = $cocktail['idDrink'];

           $detailResponse = Http::withOptions(['verify' => false])
               ->get("https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i={$idDrink}");

           if ($detailResponse->successful()) {
               $detailData = $detailResponse->json()['drinks'][0] ?? [];
               $cocktail['strCategory']     = $detailData['strCategory']     ?? null;
               $cocktail['strAlcoholic']    = $detailData['strAlcoholic']    ?? null;
               $cocktail['strInstructions'] = $detailData['strInstructions'] ?? null;
           }
           $detailedCocktails[] = $cocktail;
       }

       // 5. Retornar la vista con los datos
       return view('home', [
           'cocktails'   => $detailedCocktails,
           'currentPage' => $page,
           'totalPages'  => $totalPages,
       ]);
   }

   //* Permite buscar un cóctel a través de la API.
    public function search(Request $request)
    {
        $query = $request->input('query');
        try {
            $response = Http::withOptions(['verify' => false])
                ->get("https://www.thecocktaildb.com/api/json/v1/1/search.php?s=" . urlencode($query));
            if ($response->successful()) {
                $results = $response->json()['drinks'] ?? [];
    
                // Asegurarnos de que sea un array
                if (!is_array($results)) {
                    $results = [];
                }
    
            } else {
                $results = [];
                session()->flash('error', 'Error en la búsqueda');
            }
        } catch (\Exception $e) {
            $results = [];
            session()->flash('error', 'Excepción: ' . $e->getMessage());
        }
        return view('search', compact('results'));
    }

   
     // En CocktailController.php
    public function ajaxSearch(Request $request)
    {
        // Leer filtros y página
        $name     = $request->input('name');       // Búsqueda por nombre
        $category = $request->input('category');   // Filtro por categoría
        $type     = $request->input('type');       // Filtro por tipo (Alcoholic / Non_Alcoholic)
        $page     = $request->input('page', 1);    // Página actual (por defecto 1)

        try {
            // 1. Construir la URL de la API según el filtro
            $url = $this->buildApiUrl($name, $category, $type);

            // Si no hay ningún filtro, retornamos array vacío
            if (!$url) {
                return response()->json([
                    'cocktails'    => [],
                    'currentPage'  => 1,
                    'totalPages'   => 1,
                ]);
            }

            // 2. Llamar a la API para obtener la lista básica de cócteles
            $response = Http::withOptions(['verify' => false])->get($url);

            // Si falla, retornamos vacío
            if (!$response->successful()) {
                return response()->json([
                    'cocktails'    => [],
                    'currentPage'  => 1,
                    'totalPages'   => 1,
                ]);
            }

            // 3. Obtenemos la lista básica (solo idDrink, strDrink, strDrinkThumb, etc.)
            $cocktails = $response->json()['drinks'] ?? [];

            // Si no hay resultados, devolvemos inmediatamente
            if (empty($cocktails)) {
                return response()->json([
                    'cocktails'    => [],
                    'currentPage'  => 1,
                    'totalPages'   => 1,
                ]);
            }

            // 4. Paginar manualmente: dividimos en chunks de 12
            $chunks = array_chunk($cocktails, 12);
            $totalPages = count($chunks);

            // Asegurarnos de que la página solicitada sea válida
            if ($page < 1) {
                $page = 1;
            } elseif ($page > $totalPages) {
                $page = $totalPages;
            }

            // Extraemos el chunk correspondiente a la página actual
            $cocktailsPage = $chunks[$page - 1];

            // 5. Obtener detalles (categoría, instrucciones, tipo) de los 12 cócteles de la página
            $detailed = $this->getDetailedCocktails($cocktailsPage);

            // 6. Retornar JSON con los cócteles y datos de paginación
            return response()->json([
                'cocktails'    => $detailed,
                'currentPage'  => $page,
                'totalPages'   => $totalPages,
            ]);
        } catch (\Exception $e) {
            // En caso de excepción, retornamos error 500 con el mensaje
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    private function buildApiUrl($name, $category, $type)
    {
        // Filtro por nombre
        if ($name) {
            return "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=" . urlencode($name);
        }

        // Filtro por categoría
        if ($category) {
            // Ejemplo: 'Ordinary_Drink' o 'Cocktail'
            return "https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=" . urlencode($category);
        }

        // Filtro por tipo (Alcoholic o Non_Alcoholic)
        if ($type) {
            return "https://www.thecocktaildb.com/api/json/v1/1/filter.php?a=" . urlencode($type);
        }

        // Si no hay ningún filtro
        return null;
    }


    private function getDetailedCocktails(array $cocktails)
    {
        $detailed = [];

        foreach ($cocktails as $cocktail) {
            $id = $cocktail['idDrink'] ?? null;
            if (!$id) continue;

            // Llamada a lookup.php para detalles
            $detailResponse = Http::withOptions(['verify' => false])
                ->get("https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i={$id}");

            if ($detailResponse->successful()) {
                $detailData = $detailResponse->json()['drinks'][0] ?? [];

                // Mezclar datos básicos con los detalles
                $cocktail = array_merge($cocktail, [
                    'strCategory'     => $detailData['strCategory']     ?? 'N/A',
                    'strInstructions' => $detailData['strInstructions'] ?? 'N/A',
                    'strAlcoholic'    => $detailData['strAlcoholic']    ?? 'N/A',
                ]);
            }

            $detailed[] = $cocktail;
        }

        return $detailed;
    }



    public function storeFavorite(Request $request)
{
    $data = $request->validate([
        'cocktail_id_api' => 'required|string',
        'name'            => 'required|string',
        'thumbnail'       => 'nullable|url'
    ]);

    // Hacemos una segunda petición a lookup.php para obtener category, instructions, alcoholic
    try {
        $detailResponse = Http::withOptions(['verify' => false])
            ->get("https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i={$data['cocktail_id_api']}");
        
        if ($detailResponse->successful()) {
            $detailData = $detailResponse->json()['drinks'][0] ?? [];
            $data['category']     = $detailData['strCategory']     ?? null;
            $data['instructions'] = $detailData['strInstructions'] ?? null;
            $data['alcoholic']    = $detailData['strAlcoholic']    ?? null;
        }
    } catch (\Exception $e) {
        \Log::error('Error al obtener detalles del cóctel: ' . $e->getMessage());
        return response()->json(['error' => 'Error al obtener detalles del cóctel. Por favor, inténtalo más tarde.'], 500);
    }

    $data['user_id'] = auth()->id();

    try {
        \App\Models\Cocktail::create($data);
        return response()->json(['success' => 'Cóctel agregado a favoritos']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
}

}
