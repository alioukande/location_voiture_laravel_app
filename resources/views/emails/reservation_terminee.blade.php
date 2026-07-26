

<h2>Réservation terminée</h2>

<p>Bonjour {{ $reservation->user->name }},</p>

<p>Votre réservation est maintenant terminée.</p>

<p>
Voiture :
{{ $reservation->voiture->marque }}
{{ $reservation->voiture->model }}
</p>

<p>
Date début : {{ $reservation->start_time }}
</p>

<p>
Date fin : {{ $reservation->end_time }}
</p>

<p>Merci d'avoir utilisé notre plateforme de location de voitures.</p>
