<?php

namespace App\Http\Controllers\Admin;
use App\Mail\ReservationTerminee;

use App\Mail\ReservationAnnulee;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Voiture;
use App\Models\Assurance;
use Carbon\Carbon;

class ReservationController extends Controller
{
    
    public function index( Request $request)
    {
        $query = Reservation::with(['user', 'voiture', 'assurance']);

if ($request->filled('statut')) {
    $query->where('statut', $request->statut);
}

$reservations = $query->latest()->get();

        return view('admin.reservations.index', compact('reservations'));
    }

   
    public function create()
    {
        $voitures = Voiture::all();
        $users = User::all();
        $assurances = Assurance::all();
        return view('admin.reservations.create', compact('users', 'voitures', 'assurances'));




    }



 public function store(Request $request)
{

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'voiture_id' => 'required|exists:voitures,id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
    ]);

    $voiture = Voiture::findOrFail($request->voiture_id);

if ($voiture->statut != 'disponible') {
    return response()->json([
        'message' => 'Cette voiture est déjà réservée.'
    ], 422);
}
    $assurance = $request->assurance_id ? Assurance::find($request->assurance_id) : null;

    $start_time = $request->date_debut . ' 00:00:00';
    $end_time = $request->date_fin . ' 23:59:59';


    $jour = Carbon::parse($request->date_debut)
        ->diffInDays(Carbon::parse($request->date_fin)) ;

        if ($jour <= 0) {
    $jour = 1;
}
    $prixVoiture = $jour * $voiture->prix_par_jour;
    $prixAssurance = $assurance ? $assurance->prix_base : 0;
    $total = $prixVoiture + $prixAssurance;

    Reservation::create([
        'user_id' => $request->user_id,
        'voiture_id' => $request->voiture_id,
        'assurance_id' => $request->assurance_id,
        'start_time' => $start_time,
        'end_time' => $end_time,
        'statut' => 'en attente',
        'total_price' => $total,
    ]);

    return redirect()->route('admin.reservations.index')
                     ->with('success', 'Réservation créée avec succès');
}
    
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $voitures = Voiture::all();
        $users = User::all();
        $assurances = Assurance::all();

        return view('admin.reservations.edit', compact('reservation', 'voitures', 'users', 'assurances'));
    }

   
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'voiture_id' => 'required|exists:voitures,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $reservation->update($request->all());

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation mise à jour');
    }

   
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation supprimée');
    }

    
    public function confirmer(Reservation $reservation)
    {
        $reservation->update(['statut' => 'confirmee']);
         $reservation->voiture->update([
            'statut' => 'reservee' ,
             'disponible' => false,
            ]);

         Mail::to($reservation->user->email)
        ->send(new ReservationConfirmee($reservation));

        return back()->with('success', 'Réservation confirmee et mail envoyer');
    }

    
    public function annuler(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);
        Mail::to($reservation->user->email)
            ->send(new ReservationAnnulee($reservation));

        $reservation->voiture->update([
            'statut' => 'disponible' ,
             'disponible' => true,
            ]);



        return back()->with('success', 'Réservation annulee');
    }

   
    public function terminer(Reservation $reservation)
    {
        $reservation->update(['statut' => 'terminee']);

         $reservation->voiture->update(['statut' => 'disponible' ]);

         Mail::to($reservation->user->email)
        ->send(new ReservationTerminee($reservation));

        return back()->with('success', 'Réservation terminee');
    }
}