<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AlbumGenre extends Pivot
{
    protected $table = 'album_genre';
}
