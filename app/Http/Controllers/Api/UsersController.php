<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->username;

        $usernames =  User::where('username', 'LIKE', "$search%")
            ->pluck('username')
            ->take(5);

        return $usernames->map(function ($username) {
            return ['value' => $username];
        });
    }
}
