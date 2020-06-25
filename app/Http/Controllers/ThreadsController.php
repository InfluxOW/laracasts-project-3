<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ThreadsRequest;
use App\Inspections\Spam;
use App\Sorts\CountsByPeriod;
use App\Sorts\CountsByPeriodSort;
use App\Thread;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

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
    public function store(ThreadsRequest $request, Spam $spam)
    {
        $this->authorize(Thread::class);
        try {
            $spam->detect($request->body);
            $spam->detect($request->title);
            $thread = $request->user()->threads()->create($request->validated());

            flash('Thread has been created!')->success();
            return redirect()->route('threads.show', [$thread->channel, $thread]);
        } catch (ValidationException $e) {
            flash($e->getMessage())->error();
            return redirect()->route('threads.index');
        }

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
