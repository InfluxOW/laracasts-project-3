<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class PinnedThreadsController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->timestamps = false;

        $thread->update(['pinned' => true]);
    }

    public function destroy(Thread $thread)
    {
        $thread->timestamps = false;

        $thread->update(['pinned' => false]);
    }
}
