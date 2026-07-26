<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\Avis;

class Voiture extends Model
{
    //
    protected $fillable = [

    'model',
    'marque',
    'prix_par_jour',
    'annee',
    'image',
    'statut',
 



    ];


    public function assurances()
    {
        return $this->belongsToMany(
            Assurance::class,
            'assurance_voiture'
        );


    }

    public function reservations()
{
    return $this->hasMany(Reservation::class);
}

// public function avis()
// {
//     return $this->hasMany(Avis::class);
// }


}
