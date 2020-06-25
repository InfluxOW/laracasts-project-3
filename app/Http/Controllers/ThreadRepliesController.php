<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ThreadRepliesRequest;
use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class ThreadRepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy', 'update');
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
     * @param Spam $spam
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ThreadRepliesRequest $request, $channel, Thread $thread, Spam $spam)
    {
        $this->authorize(Reply::class);
        try {
            $spam->detect($request->body);
            $reply = $thread->addReply($request->validated(), $request->user());

            return $reply->load('user')->loadCount('favorites');
        } catch (ValidationException $e) {
            return response($e->getMessage(), 422);
        }
    }

    public function show(Reply $reply)
    {
        //
    }

    public function edit(Reply $reply)
    {
        //
    }

    public function update(ThreadRepliesRequest $request, Reply $reply, Spam $spam)
    {
        $this->authorize($reply);

        try {
            $spam->detect($request->body);
            $reply->update($request->validated());
        } catch (ValidationException $e) {
            return response($e->getMessage(), 422);
        }
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
