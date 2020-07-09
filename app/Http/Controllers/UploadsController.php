<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadsRequest;
use App\Services\UploadService;
use App\User;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    protected UploadService $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->middleware('auth');
        $this->uploadService = $uploadService;
    }

    public function store(UploadsRequest $request, $filename, $folder)
    {
        return $this->uploadService->upload($request->file($filename), $folder);
    }
}
