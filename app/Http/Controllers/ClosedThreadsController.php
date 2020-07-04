<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ClosedThreadsController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $this->authorize('close', $thread);

        $thread->close();
    }
}
