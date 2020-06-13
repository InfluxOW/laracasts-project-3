<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(Request $request, string $type, int $id)
    {
        $favoriteable = $this->identifyModel($type, $id);
        $request->user()->toggleFavorite($favoriteable);

        return redirect()->back();
    }
}
