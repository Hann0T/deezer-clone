<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function get(Request $request, string $id)
    {
        $album =  Album::with(['artist', 'tracks', 'genres'])
            ->findOrFail($id);
        return response()->json($album);
    }
}
