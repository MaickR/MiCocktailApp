@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    <h1>Configuración de Perfil</h1>
    <hr>

      {{-- Si hubo errores (contraseña actual incorrecta, validaciones fallidas, etc.) --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    {{-- Mensaje de estado (opcional) --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Perfil actualizado correctamente.
        </div>
    @elseif (session('status') === 'password-updated')
        <div class="alert alert-success">
            Contraseña actualizada correctamente.
        </div>
    @elseif (session('status') === 'account-deleted')
        <div class="alert alert-success">
            Cuenta eliminada correctamente.
        </div>
    @endif

    {{-- Tarjeta para actualizar datos del perfil --}}
    <div class="card mb-3">
        <div class="card-header">Información de Perfil</div>
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    
    {{-- Tarjeta para cambiar contraseña --}}
    <div class="card mb-3">
        <div class="card-header">Cambiar Contraseña</div>
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Tarjeta para eliminar cuenta --}}
    <div class="card">
        <div class="card-header">Eliminar Cuenta</div>
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
