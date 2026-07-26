@extends('layouts.admin')

@section('content')
<h2>Liste des réservations</h2>

<div class="mb-3">
    <form method="GET" action="{{ route('admin.reservations.index') }}">

        <select name="statut" class="form-select w-25" onchange="this.form.submit()">
            <option value="">Tous</option>
            <option value="en attente">En attente</option>
            <option value="confirmee">Confirmee</option>
            <option value="terminee">Terminee</option>
            <option value="annulee">Annulee</option>
        </select>

    </form>
</div>

<!-- Bouton + pour créer une réservation -->
<a href="{{ route('admin.reservations.create') }}" class="btn btn-success mb-3">+ Nouvelle réservation</a>


<table class="table table-bordered">


    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Voiture</th>
            <th>Assurance</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Total (DH)</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->user?->name }}</td>
            <td>{{ $reservation->voiture->marque }} {{ $reservation->voiture->model }}</td>
            <td>{{ $reservation->assurance ? $reservation->assurance->type : 'Aucune' }}</td>
            <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y') }}</td>
            <td>{{ $reservation->total_price }}</td>

            <!-- Badge pour statut -->
            <td>
                @if($reservation->statut == 'en attente')
                    <span class="badge bg-warning">en attente</span>
                @elseif($reservation->statut == 'confirmee')
                    <span class="badge bg-success">Confirmee</span>
                @elseif($reservation->statut == 'annulee')
                    <span class="badge bg-danger">annulee</span>
                @elseif($reservation->statut == 'terminee')
                    <span class="badge bg-primary">terminee</span>
                @endif
            </td>

            <!-- Actions -->
            <td>
                <div class="d-flex gap-1">

                    <!-- Confirmer -->
                    @if($reservation->statut == 'en attente')
                        <form action="{{ route('admin.reservations.confirmer', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Confirmer</button>
                        </form>

                        <!-- Annuler -->
                        <form action="{{ route('admin.reservations.annuler', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Annuler</button>
                        </form>
                    @endif

                    <!-- Terminer (après confirmation) -->
                    @if($reservation->statut == 'confirmee')
                        <form action="{{ route('admin.reservations.terminer', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Terminer</button>
                        </form>
                    @endif

                    <!-- Supprimer -->
                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                    </form>

                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection