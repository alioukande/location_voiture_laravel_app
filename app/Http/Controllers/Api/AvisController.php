<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Avis;
use App\Models\Reservation;

class AvisController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'reservation_id' => 'required|exists:reservations,id',
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string|max:500',
    ]);

    $reservation = Reservation::findOrFail($request->reservation_id);

    if ($reservation->user_id != auth()->id()) {
        return response()->json([
            'message' => 'Vous ne pouvez pas noter cette réservation.'
        ], 403);
    }

    if ($reservation->statut != 'terminee') {
        return response()->json([
            'message' => 'Vous ne pouvez noter qu\'une réservation terminée.'
        ], 400);
    }

    if ($reservation->avis) {
        return response()->json([
            'message' => 'Vous avez déjà donné un avis.'
        ], 400);
    }

    $avis = Avis::create([
        'reservation_id' => $reservation->id,
        'user_id' => auth()->id(),
        'note' => $request->note,
        'commentaire' => $request->commentaire,
    ]);

    return response()->json([
        'message' => 'Merci pour votre avis !',
        'avis' => $avis
    ], 201);
}


  public function index($id)
{
    $avis = Avis::with('user:id,name')
        ->whereHas('reservation', function ($query) use ($id) {
            $query->where('voiture_id', $id);
        })
        ->select('id', 'reservation_id', 'note', 'commentaire', 'created_at', 'user_id')
        ->latest()
        ->get();

    return response()->json($avis);
}
   
}
