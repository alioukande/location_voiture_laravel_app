<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voiture;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Assurance;
use App\Models\Avis;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller

{
    public function index()
    {
        // dd(auth()->user()->role);

        if(auth()->user()->role !== 'admin'){
         abort(403);
         }

        $totalvoitures=Voiture::count();
        $totalreservations=Reservation::count();
        $totalassurances=Assurance::count();
        $totalusers=User::count();
        $totalAvis = Avis::count();
        $noteMoyenne = round(Avis::avg('note'), 1);

        $voituresdisponibles = Voiture::where('statut','disponible')->count();
        $voituresreservees = Voiture::where('statut','reservee')->count();
        $voitureslouees = Voiture::where('statut','louee')->count();


        $voitures = Voiture::all();
        $assurances=Assurance::all();


$enAttente = Reservation::where('statut', 'en_attente')->count();
$confirmees = Reservation::where('statut', 'confirmee')->count();
$terminees = Reservation::where('statut', 'terminee')->count();
$annulees = Reservation::where('statut', 'annulee')->count();

// Revenu total
$revenu = Reservation::whereIn('statut', [
    'confirmee',
    'terminee'
])->sum('total_price');

// Voiture la plus louée
$voiturePlusLoue = Reservation::select('voiture_id')
    ->selectRaw('COUNT(*) as total')
    ->with('voiture')
    ->groupBy('voiture_id')
    ->orderByDesc('total')
    ->first();

    $reservationsParMois = Reservation::select(
        DB::raw('MONTH(created_at) as mois'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('mois')
    ->orderBy('mois')
    ->get();




        return view('admin/dashboard' , compact(
            'totalvoitures',
            'totalreservations', 
            'totalassurances', 
             'totalusers',
             'totalAvis',
             'noteMoyenne',
             'voituresdisponibles',
             'voituresreservees',
             'voitureslouees',
             'voitures',
             'assurances',
              'enAttente',
                'confirmees',
                'terminees',
                'annulees',
                'revenu',
                'voiturePlusLoue',
                'reservationsParMois'


             ));


       
    }
    //
}
