@extends('layouts.admin')


@section('content')

<h1>Ajouter une voiture</h1>

<form action="{{ route('voitures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Marque -->
    <div class="mb-3">
        <label>Marque</label>
        <input type="text" name="marque" class="form-control" required value="{{ old('marque') }}">
    </div>

    <!-- Modèle -->
    <div class="mb-3">
        <label>Model</label>
        <input type="text" name="model" class="form-control" required value="{{ old('model') }}">
    </div>

    <!-- Année -->
    <div class="mb-3">
        <label>Annee</label>
        <input type="number" name="annee" class="form-control" required value="{{ old('annee') }}">
    </div>

    <!-- Prix par jour -->
    <div class="mb-3">
        <label>Prix_par_jour (DH)</label>
        <input type="number" step="0.01" name="prix_par_jour" class="form-control" required value="{{ old('prix_par_jour') }}">
    </div>

    <!-- Image -->
    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- Statut -->
    <div class="mb-3">
        <label>Statut</label>
        <select name="statut" class="form-control">
            <option value="disponible" {{ old('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="reservee" {{ old('statut') == 'reservee' ? 'selected' : '' }}>Reservee</option>
            <option value="louee" {{ old('statut') == 'louee' ? 'selected' : '' }}>Louee</option>
            <option value="maintenance" {{ old('statut') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
    </div>

    <hr>

    <!-- Assurances -->
    <h3 class="mt-4">Assurances</h3>
    <div class="row">
        @foreach($assurances as $assurance)
            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow-sm">
                    <div class="form-check">
                        <input 
                            class="form-check-input"
                            type="checkbox"
                            name="assurances[]"
                            value="{{ $assurance->id }}"
                            id="assurance{{ $assurance->id }}"
                        >
                        <label class="form-check-label" for="assurance{{ $assurance->id }}">
                            <strong>{{ $assurance->type }}</strong> - Prix : {{ $assurance->prix_base }} DH
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
</form>

@endsection
