<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChannelsController extends Controller
{
    public function index()
    {
        return Cache::get('channels');
    }
}
