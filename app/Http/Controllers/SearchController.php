<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        if ($request->expectsJson()) {
            $search = $request->q;
            $threads = Thread::search($search)->paginate(20);

            return $threads;
        }

        return view('search.threads');
    }
}
