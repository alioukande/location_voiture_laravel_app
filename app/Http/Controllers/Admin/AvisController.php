<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReponseAvisMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Avis;
class AvisController extends Controller
{
     public function index()
    {
        $avis = Avis::with([
            'user',
            'reservation.voiture'
        ])
        ->latest()
        ->get();

        return view('admin.avis.index', compact('avis'));
    }

    public function destroy(Avis $avis)
    {
        $avis->delete();

        return back()->with(
            'success',
            'Avis supprimé avec succès'
        );
    }

    public function repondre(Request $request, Avis $avis)
{
    $request->validate([
        'reponse_admin' => 'required|string|max:1000',
    ]);

    $avis->update([
        'reponse_admin' => $request->reponse_admin,
    ]);
    Mail::to($avis->user->email)
    ->send(new ReponseAvisMail($avis));

    return back()->with(
        'success',
        'Réponse envoyée.'
    );
}


   
}
