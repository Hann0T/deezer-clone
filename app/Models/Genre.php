<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class Genre extends Model implements JsonSerializable
{
    use HasFactory;

    public function albums()
    {
        return $this
            ->belongsToMany(Album::class, 'album_genre', 'genre_id', 'album_id')
            ->using(AlbumGenre::class);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
