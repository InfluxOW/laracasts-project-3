<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class BestRepliesController extends Controller
{

    /**
     * BestRepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy');
    }

    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);
        $reply->markAsBest();
    }
}
