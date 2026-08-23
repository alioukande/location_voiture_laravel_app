<?php

namespace Tests\Feature\Api;

use App\Models\Avis;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Voiture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvisControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_avis_for_a_voiture(): void
    {
        $user = User::factory()->create();

        $voiture = Voiture::create([
            'model' => 'Clio',
            'marque' => 'Renault',
            'prix_par_jour' => 250,
            'annee' => 2022,
            'image' => 'voitures/clio.jpg',
            'statut' => 'disponible',
        ]);

        $reservation = Reservation::create([
            'voiture_id' => $voiture->id,
            'name' => 'Test',
            'email' => 'test@example.com',
            'date_reservation' => '2026-08-21',
            'start_time' => '2026-08-21',
            'end_time' => '2026-08-23',
            'total_price' => 500,
        ]);

        Avis::create([
            'reservation_id' => $reservation->id,
            'user_id' => $user->id,
            'note' => 5,
            'commentaire' => 'Très bonne voiture',
        ]);

        $response = $this->getJson('/api/voitures/' . $voiture->id . '/avis');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'note' => 5,
                'commentaire' => 'Très bonne voiture',
            ]);
    }
}