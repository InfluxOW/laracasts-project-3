<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAvatarRequest;
use App\Services\UploadService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserImagesController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->middleware('auth');
        $this->uploadService = $uploadService;
    }

    public function store(UserAvatarRequest $request, User $user, $filename, $folder)
    {
        $this->authorize('update', $request->user());

        $this->uploadService->remove($user->avatar_path);

        return $this->uploadService->upload($request->file($filename), $folder);
    }
}
