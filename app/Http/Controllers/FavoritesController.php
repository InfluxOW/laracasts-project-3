<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\LaravelFavorite\Favorite;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $favoriteable = $this->identifyModel($type, $id);
        $user->toggleFavorite($favoriteable);

        return redirect()->back();
    }
}
