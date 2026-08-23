<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Login réussi',
            ]);
    }

    public function test_user_can_register(): void
{
    $response = $this->postJson('/api/register', [
        'name' => 'Aliou Test',
        'email' => 'register@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'status' => true,
            'message' => 'Utilisateur créé',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'register@example.com',
        'name' => 'Aliou Test',
    ]);
}

public function test_authenticated_user_can_get_profile(): void
{
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/user');

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
        ]);
}

public function test_authenticated_user_can_logout(): void
{
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Déconnecté avec succès',
        ]);
}

public function test_authenticated_user_can_update_profile(): void
{
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/profile', [
        'name' => 'Aliou Modifie',
        'telephone' => '0600000000',
        'adresse' => 'Casablanca',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Profil mis à jour',
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Aliou Modifie',
        'telephone' => '0600000000',
        'adresse' => 'Casablanca',
    ]);
}
public function test_authenticated_user_can_update_photo(): void
{
    Storage::fake('public');

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $file = UploadedFile::fake()->image('profile.jpg');

    $response = $this->postJson('/api/profile/photo', [
        'photo' => $file,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
        ]);

    $photo = $user->fresh()->photo;

    $this->assertNotNull($photo);

    Storage::disk('public')->assertExists($photo);
}

}