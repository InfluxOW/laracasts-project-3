<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ThreadRepliesRequest;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ThreadRepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy', 'update');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * @param ThreadRepliesRequest $request
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ThreadRepliesRequest $request, Channel $channel, Thread $thread)
    {
        $this->authorize(Reply::class);
        $reply = $thread->addReply($request->validated());

        flash('Reply has been created!')->success();
        return redirect()->route('threads.show', [$channel, $thread]);
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

        if (! $request->wantsJson()) {
            return redirect()->route('threads.show', [$reply->thread->channel, $reply->thread]);
        }
    }
}
