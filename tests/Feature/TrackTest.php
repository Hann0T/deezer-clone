<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_a_track(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();

        $response = $this->actingAs($user)->get('/api/track/' . $track->id);
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse, json_decode($track->toJson(), true));
    }

    public function test_cannot_get_a_track_without_token(): void
    {
        $response = $this
            ->withHeader('accept', 'application/json')
            ->get('/api/track/1');

        $response->assertStatus(401);
    }

    public function test_cannot_get_a_non_existing_track(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/api/track/10');

        $response->assertStatus(404);
    }

    public function test_cannot_search_a_track_without_token(): void
    {
        $response = $this
            ->withHeader('accept', 'application/json')
            ->get('/api/search');

        $response->assertStatus(401);
    }

    public function test_serach_without_query_should_return_empty_data(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/api/search');

        $response->assertStatus(200);
        $this->assertEquals($response->json()["data"], []);
    }

    public function test_can_search_a_song_by_title(): void
    {
        $user = User::factory()->create();
        Track::factory(50)->create();
        $track = Track::factory()->create(['title' => 'Human sadness']);

        $response = $this->actingAs($user)->get('/api/search?q=' . 'human');
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse["data"][0]['title'], $track->title);
        $this->assertEquals($jsonResponse["data"][0]['duration'], $track->duration);
        $this->assertEquals($jsonResponse["data"][0]['rank'], $track->rank);
    }

    public function test_can_search_a_song_by_artist_name(): void
    {
        $artist = Artist::factory()->create(['name' => 'Julian Casablancas']);
        $album = Album::factory()->create(['title' => 'Tyranny', 'artist_id' => $artist->id]);
        $track = Track::factory()->create(['title' => 'Human sadness', 'album_id' => $album->id]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/search?q=' . 'julian');
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse["data"][0]['title'], $track->title);
        $this->assertEquals($jsonResponse["data"][0]['duration'], $track->duration);
        $this->assertEquals($jsonResponse["data"][0]['rank'], $track->rank);
    }

    public function test_can_search_a_song_by_album_title(): void
    {
        $artist = Artist::factory()->create(['name' => 'Julian Casablancas']);
        $album = Album::factory()->create(['title' => 'Tyranny', 'artist_id' => $artist->id]);
        $track = Track::factory()->create(['title' => 'Human sadness', 'album_id' => $album->id]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/search?q=' . 'tyranny');
        $jsonResponse = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($jsonResponse["data"][0]['title'], $track->title);
        $this->assertEquals($jsonResponse["data"][0]['duration'], $track->duration);
        $this->assertEquals($jsonResponse["data"][0]['rank'], $track->rank);
    }
}
