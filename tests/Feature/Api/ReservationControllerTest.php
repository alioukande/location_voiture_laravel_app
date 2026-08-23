<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Voiture;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_reservation(): void
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

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/reservations', [
            'voiture_id' => $voiture->id,
            'start_time' => '2026-08-21 10:00:00',
            'end_time' => '2026-08-23 10:00:00',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Réservation créée',
            ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'voiture_id' => $voiture->id,
            'total_price' => 500,
            'statut' => 'en attente',
        ]);
    }
}