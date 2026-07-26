<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\User;
// use App\Models\voiture;

class Avis extends Model
{
    protected $fillable=[
        'reservation_id',
        'user_id',
        'note',
        'commentaire',
        'reponse_admin',


    ];


    public function reservation()
{
    return $this->belongsTo(Reservation::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

// public function voiture()
// {
//     return $this->belongsTo(Voiture::class);
// }
    //
}
