<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function get(Request $request, string $id)
    {
        try {
            $artist = Artist::findOrFail($id);
            return response()->json($artist);
        } catch (\Exception $e) {
            return response()->json([])->setStatusCode(404);
        }
    }
}
