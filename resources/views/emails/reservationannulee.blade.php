

<h2>Réservation annulée</h2>

<p>Bonjour {{ $reservation->user->name }},</p>

<p>Votre réservation a été annulée.</p>

<p>
Voiture : {{ $reservation->voiture->marque }} {{ $reservation->voiture->model }} <br>
Du : {{ $reservation->start_time }} au {{ $reservation->end_time }}
</p>

<p>Merci.</p>