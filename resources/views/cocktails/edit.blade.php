@extends('layouts.app')

@section('content')
<h1 class="mb-4">Editar Cóctel</h1>
<form method="POST" action="{{ route('cocktails.update', $cocktail->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Nombre *</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $cocktail->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Categoría</label>
        <input type="text" class="form-control" name="category" value="{{ old('category', $cocktail->category) }}">
    </div>
    <div class="mb-3">
        <label for="instructions" class="form-label">Instrucciones</label>
        <textarea class="form-control" name="instructions">{{ old('instructions', $cocktail->instructions) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="thumbnail" class="form-label">URL de la imagen</label>
        <input type="url" class="form-control" name="thumbnail" value="{{ old('thumbnail', $cocktail->thumbnail) }}">
    </div>
    <button type="submit" class="btn btn-success">Actualizar Cóctel</button>
    <a href="{{ route('cocktails.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
