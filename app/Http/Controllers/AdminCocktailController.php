<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cocktail;

class AdminCocktailController extends Controller
{
    //* Muestra la lista de cócteles favoritos del usuario.
    public function index()
    {
        try {
            $cocktails = Cocktail::where('user_id', auth()->id())->get();
            return view('dashboard', compact('cocktails'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar los cócteles: ' . $e->getMessage());
        }
    }

    //* Muestra el formulario para crear un nuevo cóctel
    public function create()
    {
        return view('cocktails.create');
    }

   //*  Almacena un nuevo cóctel en la base de datos.
    public function store(Request $request)
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
            return redirect()->route('cocktails.index')->with('success', 'Cóctel guardado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    //* Muestra el formulario para editar un cóctel.
    public function edit($id)
    {
        try {
            $cocktail = Cocktail::findOrFail($id);
            return view('cocktails.edit', compact('cocktail'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    //* Actualiza la información del cóctel.
    public function update(Request $request, $id)
    {
    $data = $request->validate([
        'name'         => 'required|string',
        'category'     => 'nullable|string',
        'alcoholic'    => 'nullable|string',
        'instructions' => 'nullable|string',
        'thumbnail'    => 'nullable|url'
    ]);

    try {
        $cocktail = Cocktail::findOrFail($id);
        $cocktail->update($data);
        return redirect()->route('cocktails.index')->with('success', 'Cóctel actualizado correctamente');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
    }
    }


   //* Elimina un cóctel de la base de datos.
    public function destroy($id)
    {
        try {
            $cocktail = Cocktail::findOrFail($id);
            $cocktail->delete();
            return response()->json(['success' => 'Cóctel eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }
}
