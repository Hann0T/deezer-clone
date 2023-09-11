<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_id', 'id');
    }

    public function tracks()
    {
        return $this->hasManyThrough(Track::class, Album::class);
    }
}
