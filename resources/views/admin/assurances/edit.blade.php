@extends('layouts.admin')

@section('content')

<h2>Modifier assurance</h2>

<form action="{{ route('assurances.update', $assurance->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Type</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', $assurance->type) }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $assurance->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Prix de base (DH)</label>
        <input type="number" step="0.01" name="prix_base" class="form-control" value="{{ old('prix_base', $assurance->prix_base) }}" required>
    </div>

    <button type="submit" class="btn btn-warning">Mettre à jour</button>
</form>

@endsection