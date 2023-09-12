<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function get(Request $request, string $id)
    {
        $artist = Artist::findOrFail($id);
        return response()->json($artist);
    }
}
