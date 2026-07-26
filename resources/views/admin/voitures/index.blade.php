
@extends('layouts.app')

@section('content')


<div class="container mt-4">

    <!-- Bouton Ajouter une voiture -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Liste des Voitures (Admin)</h1>
        <a href="{{ route('voitures.create') }}" class="btn btn-primary">
            + Ajouter une voiture
        </a>
    </div>

    <!-- Grille des voitures -->
    <div class="row g-4">
        @foreach($voitures as $voiture)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">

                <!-- Image -->
                @if($voiture->image)
                    <img src="{{ asset('storage/' . $voiture->image) }}" class="card-img-top" alt="{{ $voiture->modele }}">
                @endif

                <!-- Contenu de la carte -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $voiture->marque }} - {{ $voiture->modele }}</h5>
                    <p class="card-text mb-1"><strong>Année :</strong> {{ $voiture->annee }}</p>
                    <p class="card-text mb-1"><strong>Prix/jour :</strong> {{ number_format($voiture->prix_par_jour, 2) }} DH</p>
                    <p>
                    <strong>Statut :</strong>   
                        @if($voiture->statut == 'disponible')
                        <span class="badge bg-success">Disponible</span>
                        @elseif($voiture->statut == 'reservee')
                        <span class="badge bg-warning">Réservée</span>
                        @elseif($voiture->statut == 'louee')
                        <span class="badge bg-danger">Louée</span>
                        @else
                        <span class="badge bg-secondary">Maintenance</span>
                        @endif
                            </p>
                    <!-- Assurances avec checkbox -->
                    <div class="mb-2">
                        <h6>Assurances :</h6>
                        @if($voiture->assurances->count())
                            @foreach($voiture->assurances as $assurance)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="assurances[]" value="{{ $assurance->id }}" data-price="{{ $assurance->prix_base }}" id="assurance_{{ $assurance->id }}">
                                    <label class="form-check-label" for="assurance_{{ $assurance->id }}">
                                        {{ ucfirst(str_replace('_',' ', $assurance->type)) }} - {{ number_format($assurance->prix_base, 2) }} DH
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Aucune assurance disponible</p>
                        @endif
                    </div>

                    <!-- Boutons CRUD -->
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('voitures.edit', $voiture->id) }}" class="btn btn-warning flex-fill">Modifier</a>
                        <form action="{{ route('voitures.destroy', $voiture->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Voulez-vous vraiment supprimer cette voiture ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                        </form>
                        <a href="{{ route('voitures.show', $voiture->id) }}" class="btn btn-secondary flex-fill">Voir détails</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Optionnel : script pour total assurance -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="assurances[]"]');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            let total = 0;
            checkboxes.forEach(c => { if(c.checked) total += parseFloat(c.dataset.price); });
            console.log('Total assurances sélectionnées :', total);
        });
    });
});
</script>

@endsection