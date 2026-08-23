<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_can_be_displayed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_dashboard_can_be_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_profile_page_can_be_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    public function test_voitures_index_can_be_displayed(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/voitures');

    $response->assertStatus(200);
}

public function test_voitures_create_page_can_be_displayed(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/voitures/create');

    $response->assertStatus(200);
}
public function test_voiture_can_be_created(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/voitures', [
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
    ]);

    $response->assertRedirect(route('voitures.index'));

    $this->assertDatabaseHas('voitures', [
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
    ]);
}
public function test_voiture_can_be_created_with_assurance(): void
{
    $user = User::factory()->create();

    $assurance = \App\Models\Assurance::create([
        'type' => 'tous_risques',
        'description' => 'Assurance tous risques',
        'prix_base' => 100,
    ]);

    $response = $this->actingAs($user)->post('/voitures', [
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
        'assurances' => [$assurance->id],
    ]);

    $response->assertRedirect(route('voitures.index'));

    $voiture = \App\Models\Voiture::where('model', 'Clio')->first();

    $this->assertNotNull($voiture);

    $this->assertDatabaseHas('assurance_voiture', [
        'voiture_id' => $voiture->id,
        'assurance_id' => $assurance->id,
    ]);
}
public function test_voiture_can_be_created_with_image(): void
{
    $user = User::factory()->create();

    $image = \Illuminate\Http\UploadedFile::fake()->image('voiture.jpg');

    $response = $this->actingAs($user)->post('/voitures', [
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
        'image' => $image,
    ]);

    $response->assertRedirect(route('voitures.index'));

   $this->assertDatabaseHas('voitures', [
    'model' => 'Clio',
    'marque' => 'Renault',
]);
$voiture = \App\Models\Voiture::where('model', 'Clio')->first();

$this->assertNotNull($voiture->image);
$this->assertStringStartsWith('voitures/', $voiture->image);

}

public function test_voiture_can_be_updated(): void
{
    $user = User::factory()->create();

    $voiture = \App\Models\Voiture::create([
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
    ]);

    $response = $this->actingAs($user)->put(
        "/voitures/{$voiture->id}",
        [
            'model' => 'Peugeot 208',
            'marque' => 'Peugeot',
            'prix_par_jour' => 300,
            'annee' => 2025,
            'statut' => 'disponible',
        ]
    );

    $response->assertRedirect(route('voitures.index'));

    $this->assertDatabaseHas('voitures', [
        'id' => $voiture->id,
        'model' => 'Peugeot 208',
        'marque' => 'Peugeot',
        'prix_par_jour' => 300,
        'annee' => 2025,
    ]);
}
public function test_voiture_can_be_deleted(): void
{
    $user = User::factory()->create();

    $voiture = \App\Models\Voiture::create([
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
    ]);

    $response = $this->actingAs($user)->delete(
        "/voitures/{$voiture->id}"
    );

    $response->assertRedirect(route('voitures.index'));

    $this->assertDatabaseMissing('voitures', [
        'id' => $voiture->id,
    ]);
}
public function test_voiture_can_be_updated_with_image(): void
{
    $user = User::factory()->create();

    $voiture = \App\Models\Voiture::create([
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
        'image' => null,
    ]);

    $image = \Illuminate\Http\UploadedFile::fake()->image('nouvelle.jpg');

    $response = $this->actingAs($user)->put(
        "/voitures/{$voiture->id}",
        [
            'model' => 'Clio 5',
            'marque' => 'Renault',
            'prix_par_jour' => 300,
            'annee' => 2025,
            'statut' => 'disponible',
            'image' => $image,
        ]
    );

    $response->assertRedirect(route('voitures.index'));

    $voiture->refresh();

    $this->assertEquals('Clio 5', $voiture->model);
    $this->assertNotNull($voiture->image);
    $this->assertStringStartsWith('voitures/', $voiture->image);
}
public function test_voiture_with_image_can_be_deleted(): void
{
    $user = User::factory()->create();

    $voiture = \App\Models\Voiture::create([
        'model' => 'Clio',
        'marque' => 'Renault',
        'prix_par_jour' => 250,
        'annee' => 2024,
        'statut' => 'disponible',
        'image' => 'voitures/test.jpg',
    ]);

    $path = storage_path('app/public/voitures/test.jpg');

    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }

    file_put_contents($path, 'image test');

    $response = $this->actingAs($user)->delete(
        "/voitures/{$voiture->id}"
    );

    $response->assertRedirect(route('voitures.index'));

    $this->assertDatabaseMissing('voitures', [
        'id' => $voiture->id,
    ]);

    $this->assertFileDoesNotExist($path);
}
}