<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Voiture;
use App\Models\Assurance;
use Carbon\Carbon;


class ReservationController extends Controller
{

public function store(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Non authentifié'
        ], 401);
    }


    $voiture = Voiture::findOrFail($request->voiture_id);

    $jours = Carbon::parse($request->start_time)
        ->diffInDays(Carbon::parse($request->end_time));

    if ($jours == 0) {
    $jours = 1;
}

    $total = $jours * $voiture->prix_par_jour;

    if ($request->assurance_id) {
        $assurance = Assurance::find($request->assurance_id);
        if ($assurance) {
            $total += $assurance->prix_base;
        }
    }



     $reservation = Reservation::create([
        'user_id' => $user->id,
        'voiture_id' => $request->voiture_id,
        'assurance_id' => $request->assurance_id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'total_price' => $total,
        'statut' => 'en attente',
    ]);



    return response()->json([
        'message' => 'Réservation créée',
        'data' => $reservation
    ]);
}



public function annuler($id)
{
    $reservation = Reservation::findOrFail($id);

    $reservation->update([
        'statut' => 'annulee'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Réservation annulée'
    ]);
}

}



