<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ThreadsRequest;
use App\Sorts\CountsByPeriod;
use App\Sorts\CountsByPeriodSort;
use App\Thread;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create', 'destroy', 'update', 'edit');
    }

    /**
     * @param Channel|null $channel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel = null)
    {
        $query = $channel ? Thread::where('channel_id', $channel->id) : Thread::query();

        $threads = Thread::buildQuery($query)
            ->paginate(12)
            ->appends(request()->query());

        if (request()->wantsJson()) {
            return $threads;
        }

        $trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 2, 'WITHSCORES'));

        return view('threads.index', compact('threads', 'trending'));
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

        flash('Thread has been created!')->success();
        return redirect()->route('threads.show', [$thread->channel, $thread]);
    }

    /**
     * @param Request $request
     * @param string $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, string $channelSlug, Thread $thread)
    {
        if ($request->user()) {
            $request->user()->read($thread);
        }

        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $thread->title,
            'link' => $thread->link
        ]));

        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy(Thread $thread)
    {
        $this->authorize($thread);

        $thread->delete();

        flash('Thread has been deleted!')->success();
        return redirect()->route('threads.index');
    }
}
