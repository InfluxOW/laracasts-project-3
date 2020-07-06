<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserAvatarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(UserAvatarRequest $request)
    {
        $user = $request->user();
        $this->authorize('update', $user);

        if ($user->avatar_path) {
            Storage::disk('s3')->delete(parse_url($user->avatar_path, PHP_URL_PATH));
        }

        $folder = 'avatars';
        $file = $request->file('avatar');
        $path = Storage::disk('s3')->put($folder, $file, 'public');
        $url = Storage::disk('s3')->url($path);

        return $url;
    }
}
