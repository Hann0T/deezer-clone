<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Country;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::factory()->create(['name' => 'Perú']);
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'country_id' => $country->id,
        ]);

        $artist = Artist::factory()->create(['name' => 'Julian Casablancas']);
        $tyranny = Album::factory()->create(['title' => 'Tyranny', 'artist_id' => $artist->id]);

        Track::factory()->create(['title' => 'Take Me In Your Army', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Crunch Punch', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'M.utually A.ssured D.estruction', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Human sadness', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Where No Eagles Fly', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Father Electricity', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Johan Von Bronx', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Business Dog', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Xerox', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Dare I Care', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Nintendo Blood', 'album_id' => $tyranny->id]);
        Track::factory()->create(['title' => 'Off To War', 'album_id' => $tyranny->id]);

        $virtue = Album::factory()->create(['title' => 'Virtue', 'artist_id' => $artist->id]);
        Track::factory()->create(['title' => 'Leave it in my Dreams', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'QYURRYUS', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Pyramid of Bones', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Permanent High School', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'ALieNNatioN', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'One of the Ones', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'All Wordz Are Made Up', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Think Before You Drink', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Wink', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'My Friend the Walls', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Pink Ocean', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Black Hole', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Lazy Boy', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'We\'re Where We Were', 'album_id' => $virtue->id]);
        Track::factory()->create(['title' => 'Pointlessness', 'album_id' => $virtue->id]);
    }
}
