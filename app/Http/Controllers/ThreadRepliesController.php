<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadRepliesRequest;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ThreadRepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy', 'update');
        $this->middleware('verified')->only('store');
    }

    /**
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->oldest()->paginate(15);
    }

    public function create()
    {
        //
    }

    /**
     * @param ThreadRepliesRequest $request
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ThreadRepliesRequest $request, $channel, Thread $thread)
    {
        $this->authorize(Reply::class);
        $reply = $thread->addReply($request->validated(), $request->user());

        return $reply->load('user')->loadCount('favorites');
    }

    public function show(Reply $reply)
    {
        //
    }

    public function edit(Reply $reply)
    {
        //
    }

    public function update(ThreadRepliesRequest $request, Reply $reply)
    {
        $this->authorize($reply);

        $reply->update($request->validated());
    }

    public function destroy(Request $request, Reply $reply)
    {
        $this->authorize($reply);

        $reply->delete();

        if (!$request->wantsJson()) {
            return redirect()->route('threads.show', [$reply->thread->channel, $reply->thread]);
        }
    }
}
