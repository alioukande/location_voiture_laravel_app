

<h2>Nouvelle réservation en attente</h2>
<p>Voiture ID : {{ $reservation->voiture_id }}</p>
<p>Du {{ $reservation->start_time }} au {{ $reservation->end_time }}</p>
<p>Total : {{ $reservation->total_price }} DH</p>
<p>Statut : {{ $reservation->statut }}</p>
<p><a href="http://192.168.11.150:8000/admin/reservations">Voir dans l'admin</a></p>