<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TracksController extends Controller
{
    public function get(Request $request, string $id)
    {
        $track =  Track::with(['album', 'album.artist'])
            ->findOrFail($id);
        return response()->json($track);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->q;
        return Track::with(['album', 'album.artist'])
            ->where('title', 'like', "%$searchQuery%")
            ->orWhereHas('album', function (Builder $query) use ($searchQuery) {
                $query->where('title', 'like', "%$searchQuery%");
            })
            ->orWhereHas('album.artist', function (Builder $query) use ($searchQuery) {
                $query->where('name', 'like', "%$searchQuery%");
            })
            ->paginate(20)
            ->withQueryString()
            ->toJson();
    }
}
