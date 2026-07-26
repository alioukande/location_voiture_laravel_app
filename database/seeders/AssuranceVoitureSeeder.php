<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voiture;

class AssuranceVoitureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $voiture = Voiture::find(1);
        $voiture->assurances()->sync([1, 2]);
        //
    }
}
