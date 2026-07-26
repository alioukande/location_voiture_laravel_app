@extends('layouts.app')

@section('content')
<div class="alert alert-success">
Dashboard fonctionne

<div class="container mt-5">

    <h2>Détails de la réservation</h2>

    <p><strong>Voiture :</strong> {{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}</p>
    <p><strong>Nom :</strong> {{ $reservation->name }}</p>
    <p><strong>Email :</strong> {{ $reservation->email }}</p>
    <p><strong>Date :</strong> {{ $reservation->date_reservation }}</p>
    <p><strong>Heure début :</strong> {{ $reservation->start_time }}</p>
    <p><strong>Heure fin :</strong> {{ $reservation->end_time }}</p>

    <h4>Assurances choisies :</h4>
    @if($reservation->assurances->count())
        <ul>
            @foreach($reservation->assurances as $assurance)
                <li>{{ ucfirst(str_replace('_',' ',$assurance->type)) }} — {{ $assurance->prix_base }} DH</li>
            @endforeach
        </ul>
    @else
        <p>Aucune assurance choisie.</p>
    @endif

    <h4>Prix total : {{ $reservation->total_price }} DH</h4>

    <a href="{{ route('voitures.index') }}" class="btn btn-primary">Retour aux voitures</a>

    <div class="alert alert-success">
</div>
</div>
</div>
@endsection
