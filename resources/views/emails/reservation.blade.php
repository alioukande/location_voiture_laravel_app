

<h2>Confirmation de réservation</h2>

<p>Bonjour,</p>

<p>Votre réservation a bien été enregistrée.</p>

<p>
Date début : {{ $reservation->start_time }}
</p>

<p>
Date fin : {{ $reservation->end_time }}
</p>

<p>
Montant total : {{ $reservation->total_price }} DH
</p>

<p>
Statut : {{ $reservation->statut }}
</p>

<p>Merci pour votre confiance.</p>