<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_a_artist(): void
    {
        $user = User::factory()->create();
        $artist = Artist::factory()->create();

        $response = $this->actingAs($user)->get('/api/artist/' . $artist->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($artist->toJson(), true));
    }

    public function test_cannot_get_a_artist_without_token(): void
    {
        $response = $this
            ->withHeader('accept', 'application/json')
            ->get('/api/artist/1');

        $response->assertStatus(401);
    }

    public function test_cannot_get_a_non_existing_artist(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/api/artist/10');

        $response->assertStatus(404);
    }
}
