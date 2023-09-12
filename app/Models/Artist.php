<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class Artist extends Model implements JsonSerializable
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_id', 'id');
    }

    public function tracks()
    {
        return $this->hasManyThrough(Track::class, Album::class);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => \Illuminate\Support\Facades\URL::to('/artist/' . $this->id),
            'picture' => $this->picture,
            'nb_album' => $this->albums()->count(),
            'nb_fan' => $this->fans,
            'type' => 'artist',
            'tracklist' => 'wip'
        ];
    }
}
