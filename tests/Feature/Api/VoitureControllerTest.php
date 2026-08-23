<?php

namespace Tests\Feature\Api;

use App\Models\Voiture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoitureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_voitures(): void
    {
        Voiture::create([
            'model' => 'Clio',
            'marque' => 'Renault',
            'prix_par_jour' => 250,
            'annee' => 2022,
            'image' => 'voitures/clio.jpg',
            'statut' => 'disponible',
        ]);

        $response = $this->getJson('/api/voitures');

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }
}