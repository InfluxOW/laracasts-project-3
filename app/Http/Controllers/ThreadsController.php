<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ThreadsRequest;
use App\Sorts\CountsByPeriod;
use App\Sorts\CountsByPeriodSort;
use App\Thread;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create');
    }

    /**
     * @param Channel|null $channel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel = null)
    {
        $query = $channel ? Thread::where('channel_id', $channel->id) : Thread::query();

        $threads = QueryBuilder::for($query)
            ->allowedFilters('user.username')
            ->allowedSorts([
                AllowedSort::field('views', 'views_count'),
                AllowedSort::field('replies', 'replies_count'),
                AllowedSort::field('favorites', 'favorites_count'),
            ])
            ->latest()
            ->paginate(12)
            ->appends(request()->query());

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $thread = new Thread();

        return view('threads.create', $thread);
    }

    /**
     * @param ThreadsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ThreadsRequest $request)
    {
        $this->authorize(Thread::class);
        $thread = $request->user()->threads()->create($request->validated());

        return redirect()->route('threads.show', [$thread->channel, $thread]);
    }

    /**
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Channel $channel, Thread $thread)
    {
        views($thread)->record();

        $replies = $thread->replies()->paginate(10);

        return view('threads.show', compact('thread', 'replies'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Channel $channel, Thread $thread)
    {
        //
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        //
    }
}
