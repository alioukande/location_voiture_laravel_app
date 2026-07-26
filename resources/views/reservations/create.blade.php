<!-- @extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2>Réserver : {{ $voiture->marque }} {{ $voiture->modele }}</h2>

    @if($voiture->photo)
        <img src="{{ asset('storage/'.$voiture->photo) }}" class="img-fluid mb-3" alt="Voiture">
    @endif
<!--  -->
    <!-- <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="voiture_id" value="{{ $voiture->id }}">

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date réservation</label>
            <input type="date" name="date_reservation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Heure début</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Heure fin</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        {{-- Assurances disponibles --}}
        <div class="mb-3">
            <label>Choisir une assurance</label>
            @if($voiture->assurances->count())
                @foreach($voiture->assurances as $assurance)
                    <div class="form-check mb-2">
                        <input type="checkbox"
                               class="form-check-input assurance-checkbox"
                               name="assurances[]"
                               value="{{ $assurance->id }}"
                               data-price="{{ $assurance->prix_base }}"
                               id="assurance_{{ $assurance->id }}">
                        <label class="form-check-label" for="assurance_{{ $assurance->id }}">
                            {{ ucfirst(str_replace('_',' ',$assurance->type)) }} — {{ $assurance->prix_base }} DH
                        </label>
                    </div>
                @endforeach
            @else
                <p class="text-danger">Aucune assurance disponible pour cette voiture.</p>
            @endif
        </div>

        {{-- Total dynamique --}}
        <div class="mb-3">
            <strong>Total : <span id="total">{{ $voiture->prix_par_jour }}</span> DH</strong>
        </div>

        <button class="btn btn-success">Valider la réservation</button>
    </form>
</div> -->

<!-- {{-- JS calcul dynamique --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let prixVoiture = Number(@json($voiture->prix_par_jour));
    let totalSpan = document.getElementById('total');
    let checkboxes = document.querySelectorAll('.assurance-checkbox');

    function calculTotal() {
        let total = prixVoiture;
        checkboxes.forEach(cb => {
            if(cb.checked){
                total += Number(cb.dataset.price);
            }
        });
        totalSpan.textContent = total.toFixed(2);
    }

    checkboxes.forEach(cb => cb.addEventListener('change', calculTotal));
    calculTotal();
});
</script>
@endsection --> -->
