<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class Album extends Model implements JsonSerializable
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'artist_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    public function genres()
    {
        return $this
            ->belongsToMany(Genre::class, 'album_genre', 'album_id', 'genre_id')
            ->using(AlbumGenre::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'album_id', 'id');
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'upc' => $this->upc,
            'link' => \Illuminate\Support\Facades\URL::to('/album/' . $this->id),
            'cover' => $this->cover,
            'nb_tracks' => $this->tracks()->count(),
            'duration' => $this->tracks?->reduce(function ($carry, $item) {
                return $carry + $item->duration;
            }),
            'artist' => $this->artist,
            'tracks' => $this->tracks,
            'genres' => $this->genres,
            'type' => 'album'
        ];
    }
}
