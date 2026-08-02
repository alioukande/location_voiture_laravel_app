@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2 class="mb-4">Dashboard</h2>

<!-- Cartes statistiques -->

<div class="row g-4 mb-4">

    <!-- Total voitures -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#0dcaf0;">
            <div class="card-body text-center py-4">
                <h6>Total voitures</h6>
                <h1>{{ $totalVoitures }}</h1>
            </div>
        </div>
    </div>

    <!-- Disponibles -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#0d6efd;">
            <div class="card-body text-center py-4">
                <h6>Voitures disponibles</h6>
                <h1>{{ $voituresDisponibles }}</h1>
            </div>
        </div>
    </div>

    <!-- Réservations -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-dark" style="background:#ffc107;">
            <div class="card-body text-center py-4">
                <h6>Réservations</h6>
                <h1>{{ $totalReservations }}</h1>
            </div>
        </div>
    </div>

    <!-- Revenu -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#198754;">
            <div class="card-body text-center py-4">
                <h6>💰 Revenu total</h6>
                <h2>{{ number_format($revenu,2) }} DH</h2>
            </div>
        </div>
    </div>

    <!-- Utilisateurs -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#212529;">
            <div class="card-body text-center py-4">
                <h6>Utilisateurs</h6>
                <h1>{{ $totalUsers }}</h1>
            </div>
        </div>
    </div>

    <!-- Assurances -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#6f42c1;">
            <div class="card-body text-center py-4">
                <h6>Assurances</h6>
                <h1>{{ $totalAssurances }}</h1>
            </div>
        </div>
    </div>

    <!-- Avis -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#20c997;">
            <div class="card-body text-center py-4">
                <h6>Total avis</h6>
                <h1>{{ $totalAvis }}</h1>
            </div>
        </div>
    </div>

    <!-- Satisfaction -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow h-100 text-white" style="background:#dc3545;">
            <div class="card-body text-center py-4">
                <h6>Satisfaction</h6>
                <h2>⭐ {{ $noteMoyenne }}/5</h2>
            </div>
        </div>
    </div>

</div>

<!-- Ligne du bas -->

<div class="row g-4 mb-4">

    <!-- Carte voiture -->
    <div class="col-lg-6">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-dark text-white">
                🚗 Voiture la plus louée
            </div>

            <div class="card-body">

                @if($voiturePlusLoue)

                    <div class="text-center">

                        <img
                            src="{{ asset('storage/'.$voiturePlusLoue->voiture->image) }}"
                            class="img-fluid rounded shadow mb-3"
                            style="height:220px;width:100%;object-fit:cover;"
                        >

                        <span class="badge bg-warning text-dark fs-6 mb-3">
                            🥇 Véhicule N°1
                        </span>

                        <h3 class="fw-bold">
                            {{ $voiturePlusLoue->voiture->marque }}
                            {{ $voiturePlusLoue->voiture->model }}
                        </h3>

                    </div>

                    <hr>

                    <div class="row text-center">

                        <div class="col-6">
                            <h2 class="text-primary fw-bold">
                                {{ $voiturePlusLoue->total }}
                            </h2>
                            <small class="text-muted">Locations</small>
                        </div>

                        <div class="col-6">
                            <h2 class="text-success fw-bold">
                                {{ number_format($voiturePlusLoue->voiture->prix_par_jour,0) }} DH
                            </h2>
                            <small class="text-muted">Prix / jour</small>
                        </div>

                    </div>

                    <div class="mt-4">

                        <label class="fw-bold">
                            Popularité
                        </label>

                        <div class="progress" style="height:12px">

                            <div
                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width:85%">
                            </div>

                        </div>

                        <small class="text-success">
                            Véhicule le plus demandé actuellement
                        </small>

                    </div>

                @else

                    <div class="text-center py-5">
                        <h4>Aucune donnée disponible</h4>
                    </div>

                @endif

            </div>

        </div>

    </div>

    <!-- Doughnut -->

    <div class="col-lg-6">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-primary text-white">
                📊 Statistiques
            </div>

            <div class="card-body d-flex justify-content-center align-items-center">

                <canvas id="chartStatut"></canvas>

            </div>

        </div>

    </div>

</div>



    <hr class="my-4">

<div class="card shadow">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">
            📈 Réservations par mois
        </h5>

    </div>

    <div class="card-body">

        <canvas id="chartReservations"></canvas>

    </div>

</div>

</div>




<script>

const labels = [
    "Jan",
    "Fév",
    "Mar",
    "Avr",
    "Mai",
    "Juin",
    "Juil",
    "Août",
    "Sep",
    "Oct",
    "Nov",
    "Déc"
];

let dataReservations = new Array(12).fill(0);

@foreach($reservationsParMois as $item)

dataReservations[{{ $item->mois - 1 }}] = {{ $item->total }};

@endforeach

new Chart(document.getElementById('chartReservations'), {

    type: 'bar',

    data: {

        labels: labels,

        datasets: [{

            label: 'Réservations',

            data: dataReservations,

            backgroundColor: [
    '#3b82f6',
    '#10b981',
    '#f59e0b',
    '#ef4444',
    '#8b5cf6',
    '#06b6d4',
    '#f97316',
    '#84cc16',
    '#ec4899',
    '#6366f1',
    '#14b8a6',
    '#64748b'
],

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        }

    }

});

new Chart(document.getElementById('chartStatut'), {

    type: 'doughnut',

    data: {

        labels: [
            'En attente',
            'Confirmées',
            'Terminées',
            'Annulées'
        ],

        datasets: [{

            data: [
                {{ $enAttente }},
                {{ $confirmees }},
                {{ $terminees }},
                {{ $annulees }}
            ],

            backgroundColor: [
                '#ffc107',
                '#198754',
                '#0d6efd',
                '#dc3545'
            ],

            borderWidth: 2

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                position: 'bottom'
            },

            title: {
                display: true,
                text: 'Statut des réservations'
            }

        },

        cutout: '65%'

    }

});

</script>


@endsection
