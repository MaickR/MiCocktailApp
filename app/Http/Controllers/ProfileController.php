<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    //* Actualiza la información del perfil (nombre, email, etc.)
    public function update(Request $request)
    {
        $user = $request->user();

        // Validar nombre y correo únicos (excluyendo al usuario actual)
        $request->validate([
            'name' => [
                'required', 'string', 'min:4', 'max:10',
                Rule::unique('users', 'name')->ignore($user->id),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], [
            'name.min' => 'El nombre debe tener al menos 4 caracteres',
            'name.max' => 'El nombre no puede exceder 10 caracteres',
            'name.unique' => 'Ese nombre ya está en uso',
            'email.unique' => 'Ese correo electrónico ya está en uso',
        ]);

        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Retornar con un status para que la vista muestre SweetAlert
        return redirect()->route('profile.edit')->with('status', 'perfil-actualizado');
    }

    
    // * Actualiza la contraseña 
    public function updatePassword(Request $request)
    {
        // Validaciones servidor
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 'confirmed', 'min:4',
                function($attribute, $value, $fail) {
                    if (!preg_match('/[A-Z]/', $value)) {
                        $fail('La contraseña debe contener al menos una letra mayúscula.');
                    }
                    if (!preg_match('/[0-9]/', $value)) {
                        $fail('La contraseña debe contener al menos un dígito numérico.');
                    }
                    if (!preg_match('/[\W_]/', $value)) {
                        $fail('La contraseña debe contener al menos un carácter especial.');
                    }
                }
            ],
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Actualizar contraseña
        $user = $request->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'contraseña-actualizada');
    }

    // * Elimina la cuenta del usuario
    public function destroy(Request $request)
    {
        // Validar la contraseña actual
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.current_password' => 'La contraseña actual no coincide.',
        ]);

        $user = $request->user();

        // Eliminar usuario
         $user->delete();

        // Cerrar sesión
         auth()->logout();

        return redirect('/')->with('status', 'cuenta-eliminada');
    }

}
