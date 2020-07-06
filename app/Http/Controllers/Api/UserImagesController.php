<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserImagesRequest;
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

    public function store(UserImagesRequest $request, User $user, $filename, $folder)
    {
        $this->authorize('update', $user);
        $dbColumn = "{$filename}_path";

        $this->uploadService->remove($user->$dbColumn);
        $url = $this->uploadService->upload($request->file($filename), $folder);
        $user->update([$dbColumn => $url]);

        return $url;
    }
}
