<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

class Track extends Model implements JsonSerializable
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'album_id'];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_short' => $this->title_short,
            'duration' => $this->duration,
            'rank' => $this->rank,
            'track_position' => $this->track_position,
            'link' => \Illuminate\Support\Facades\URL::to('/track/' . $this->id),
            'artist' => $this->album->artist,
            'album' => $this->album->toArray(),
            'type' => 'track'
        ];
    }
}
