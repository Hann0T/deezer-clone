<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function albums()
    {
        return $this
            ->belongsToMany(Album::class, 'album_genre', 'genre_id', 'album_id')
            ->using(AlbumGenre::class);
    }
}
