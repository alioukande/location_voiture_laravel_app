@extends('layouts.admin')

@section('content')

<h2>Ajouter une réservation</h2>

<form action="{{ route('admin.reservations.store') }}" method="POST">
    @csrf

    <!-- Client -->
    <div class="mb-3">
        <label>Client</label>
        <select name="user_id" class="form-control" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Voiture -->
    <div class="mb-3">
        <label>Voiture</label>
        <select name="voiture_id" id="voiture" class="form-control" required>
            @foreach($voitures as $voiture)
                <option value="{{ $voiture->id }}" data-prix="{{ $voiture->prix_par_jour }}">
                    {{ $voiture->marque }} {{ $voiture->model }} ({{ $voiture->prix_par_jour }} DH/jour)
                </option>
            @endforeach
        </select>
    </div>

    <!-- Assurance -->
    <div class="mb-3">
        <label>Assurance</label>
        <select name="assurance_id" id="assurance" class="form-control">
            <option value="" data-prix="0">Aucune</option>
            @foreach($assurances as $assurance)
                <option value="{{ $assurance->id }}" data-prix="{{ $assurance->prix_base }}">
                    {{ $assurance->type }} ({{ $assurance->prix_base }} DH)
                </option>
            @endforeach
        </select>
    </div>

    <!-- Dates -->
    <div class="mb-3">
        <label>Date de début</label>
        <input type="date" name="date_debut" id="date_debut" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Date de fin</label>
        <input type="date" name="date_fin" id="date_fin" class="form-control" required>
    </div>

    <!-- Prix total -->
    <div class="mb-3">
        <label>Prix total estimé :</label>
        <p><strong id="total_price">0</strong> DH</p>
        <input type="hidden" name="total_price" id="total_price_hidden">
    </div>

    <button class="btn btn-success">Enregistrer</button>
</form>

<script>
const voitureSelect = document.getElementById('voiture');
const assuranceSelect = document.getElementById('assurance');
const startInput = document.getElementById('date_debut');
const endInput = document.getElementById('date_fin');
const totalSpan = document.getElementById('total_price');
const totalHidden = document.getElementById('total_price_hidden');

function calculerTotal() {
    const prixVoiture = parseFloat(voitureSelect.selectedOptions[0].dataset.prix || 0);
    const prixAssurance = parseFloat(assuranceSelect.selectedOptions[0].dataset.prix || 0);

    const start = new Date(startInput.value);
    const end = new Date(endInput.value);

    if (!start || !end || end < start) {
        totalSpan.innerText = 0;
        totalHidden.value = 0;
        return;
    }

    let jours = Math.ceil((end - start) / (1000*60*60*24));
    if (jours === 0) jours = 1;

    const total = (jours * prixVoiture + prixAssurance).toFixed(2);
    totalSpan.innerText = total;
    totalHidden.value = total; // IMPORTANT: pour que le controller récupère le prix
}

// recalcul automatique
voitureSelect.addEventListener('change', calculerTotal);
assuranceSelect.addEventListener('change', calculerTotal);
startInput.addEventListener('change', calculerTotal);
endInput.addEventListener('change', calculerTotal);

// initialisation
calculerTotal();
</script>

@endsection