


@extends('layouts.app')

@section('content')

<h1>Bienvenue dans notre agence de location 🚗</h1>

<p>Choisissez la meilleure voiture au meilleur prix avec Assurance.</p>

@auth
    <!-- <a href="{{ route('voitures.index') }}">Voir les voitures disponibles</a> -->
@endauth

@guest
    <!-- <a href="{{ route('register') }}">Créer un compte</a> 
     <a href="{{ route('login') }}">Se connecter</a> -->
@endguest

@endsection
