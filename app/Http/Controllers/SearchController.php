<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->q;

        $threads = Thread::search($search)->paginate(20);

        if ($request->expectsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }
}
