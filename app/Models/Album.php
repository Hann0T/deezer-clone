<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

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
}
