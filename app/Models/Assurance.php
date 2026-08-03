<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{

    protected $fillable = [
        'type',
        'description',
        'prix_base'
    ];

    public function voitures()
    {
        return $this->belongsToMany(
            Voiture::class,
            'assurance_voiture'
        );
    }

    public function reservations()
    {
         return $this->belongsToMany(Reservation::class);
    }

}
