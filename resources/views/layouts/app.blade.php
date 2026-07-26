<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Voitures</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">🚗 Location</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <!-- Liens visibles pour tous -->
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>

                <!-- Guest -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                </li>
                @endguest

                <!-- Authenticated -->
                @auth
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('voitures.index') }}">Voitures</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Profil</a>
                </li>
                <li class="nav-item">
    <form action="{{ route('logout') }}" method="POST" class="d-flex">
        @csrf
        <button type="submit" class="nav-link btn btn-link text-white p-0 m-0">
            Déconnexion
        </button>
    </form>
</li>
                @endauth

            </ul>
        </div>
    </div>
    <!-- <div>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/voitures">Voitures</a>
        <a href="/admin/assurances">Assurances</a>
        <a href="/admin/reservations">Réservations</a>

    </div> -->
</nav>

<!-- Contenu principal -->
<div class="container mt-4">
    @yield('content')
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>