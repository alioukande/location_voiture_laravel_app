<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voiture;



class VoitureController extends Controller
{

    public function index()
    {

       return response()->json(Voiture::all());



    }


}

