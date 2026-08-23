<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_assurances(): void
    {
        $response = $this->getJson('/api/assurances');

        $response->assertStatus(200);
    }

    public function test_can_get_voitures(): void
    {
        $response = $this->getJson('/api/voitures');

        $response->assertStatus(200);
    }
}