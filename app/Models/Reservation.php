<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Avis;

class Reservation extends Model
{
      protected $fillable = [
        'voiture_id',
        'user_id',
        'assurance_id',
        'start_time',
        'end_time',
        'total_price',
        'statut',
    ];

    public function voiture()
{
    return $this->belongsTo(Voiture::class);
}


    public function assurance()
{
    return $this->belongsTo(Assurance::class);
}

    public function user()
    {
    return $this->belongsTo(User::class);
    }


public function avis()
{
    return $this->hasOne(Avis::class);
}




}
