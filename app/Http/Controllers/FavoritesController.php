<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\LaravelFavorite\Favorite;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy');
        $this->middleware('verified')->only('store');
    }

    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $favoriteable = $this->identifyModel($type, $id);
        $user->favorite($favoriteable);
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $favoriteable = $this->identifyModel($type, $id);
        $user->unfavorite($favoriteable);
    }
}
