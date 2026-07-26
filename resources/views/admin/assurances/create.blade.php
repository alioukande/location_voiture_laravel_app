@extends('layouts.admin')

@section('content')

<h2>Ajouter une assurance</h2>

<form action="{{ route('admin.assurances.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Type</label>
        <input type="text" name="type" class="form-control" value="{{ old('type') }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Prix de base (DH)</label>
        <input type="number" step="0.01" name="prix_base" class="form-control" value="{{ old('prix_base') }}" required>
    </div>

    <button type="submit" class="btn btn-success">Ajouter</button>
</form>

@endsection