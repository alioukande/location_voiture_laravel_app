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

        if(auth()->user()->role !== 'admin'){
         abort(403);
         }

        $totalVoitures = Voiture::count();
        $totalReservations = Reservation::count();
        $totalAssurances = Assurance::count();
        $totalUsers = User::count();
        $totalAvis = Avis::count();
        $noteMoyenne = round(Avis::avg('note'), 1);

        $voituresDisponibles  = Voiture::where('statut','disponible')->count();
        $voituresReservees  = Voiture::where('statut','reservee')->count();
        $voituresLouees  = Voiture::where('statut','louee')->count();


        $voitures = Voiture::all();
        $assurances=Assurance::all();


$enAttente = Reservation::where('statut', 'en_attente')->count();
$confirmees = Reservation::where('statut', 'confirmee')->count();
$terminees = Reservation::where('statut', 'terminee')->count();
$annulees = Reservation::where('statut', 'annulee')->count();

$revenu = Reservation::whereIn('statut', [
    'confirmee',
    'terminee'
])->sum('total_price');


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
            'totalVoitures',
            'totalReservations',
            'totalAssurances',
             'totalUsers',
             'totalAvis',
             'noteMoyenne',
             'voituresDisponibles',
             'voituresReservees',
             'voituresLouees',
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

}
