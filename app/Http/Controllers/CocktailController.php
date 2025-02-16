<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cocktail;

class CocktailController extends Controller
{
   //* Muestra el listado de cócteles obtenidos de la API.
    public function index()
    {
        try {
            $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail');
            if ($response->successful()) {
                $cocktails = $response->json()['drinks'];
            } else {
                $cocktails = [];
                session()->flash('error', 'Error al obtener los datos de la API');
            }
        } catch (\Exception $e) {
            $cocktails = [];
            session()->flash('error', 'Excepción: ' . $e->getMessage());
        }
        return view('home', compact('cocktails'));
    }

   //* Permite buscar un cóctel a través de la API.
    public function search(Request $request)
    {
        $query = $request->input('query');
        try {
            $response = Http::get("https://www.thecocktaildb.com/api/json/v1/1/search.php?s={$query}");
            if ($response->successful()) {
                $results = $response->json()['drinks'] ?? [];
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

    /**
     * Guarda un cóctel como favorito en la base de datos.
     * Se espera que la petición AJAX envíe los datos necesarios.
     */
    public function storeFavorite(Request $request)
    {
        $data = $request->validate([
            'cocktail_id_api' => 'nullable|string',
            'name'            => 'required|string',
            'category'        => 'nullable|string',
            'instructions'    => 'nullable|string',
            'thumbnail'       => 'nullable|url'
        ]);

        $data['user_id'] = auth()->id();

        try {
            Cocktail::create($data);
            return response()->json(['success' => 'Cóctel agregado a favoritos']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
