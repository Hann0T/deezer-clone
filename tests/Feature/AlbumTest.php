<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_a_album(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();

        $response = $this->actingAs($user)->get('/api/album/' . $album->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($album->toJson(), true));
    }

    public function test_cannot_get_a_album_without_token(): void
    {
        $response = $this
            ->withHeader('accept', 'application/json')
            ->get('/api/album/1');

        $response->assertStatus(401);
    }

    public function test_cannot_get_a_non_existing_album(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/api/album/10');

        $response->assertStatus(404);
    }

    public function test_album_should_return_with_genres(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();
        $genres = Genre::factory(2)->create();
        $album->genres()->attach($genres);

        $response = $this->actingAs($user)->get('/api/album/' . $album->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($album->toJson(), true));
        $this->assertEquals($jsonResponse['genres'], json_decode($genres->toJson(), true));
    }

    public function test_album_should_return_with_artist(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();

        $response = $this->actingAs($user)->get('/api/album/' . $album->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($album->toJson(), true));
        $this->assertEquals($jsonResponse['artist'], json_decode($album->artist->toJson(), true));
    }

    public function test_album_should_return_with_tracks(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();
        $tracks = Track::factory(2)->create([
            'album_id' => $album->id
        ]);

        $response = $this->actingAs($user)->get('/api/album/' . $album->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($album->toJson(), true));
        $this->assertEquals($jsonResponse['tracks'], json_decode($tracks->toJson(), true));
        $this->assertEquals($jsonResponse['duration'], $tracks->reduce(fn ($carry, $item) => $carry + $item->duration));
    }
}
