<?php

namespace App\Observers;

use App\Reputation;
use App\Thread;

class ThreadObserver
{
    /**
     * Handle the thread "created" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function created(Thread $thread)
    {
        $thread->disableLogging();
        $thread->update(['slug' => $thread->title]);
        $thread->enableLogging();

        Reputation::award($thread->user, Reputation::THREAD_WAS_PUBLISHED);
    }

    /**
     * Handle the thread "deleting" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function deleting(Thread $thread)
    {
        $thread->replies->each->delete();
    }

    public function deleted(Thread $thread)
    {
        visits($thread)->reset();
        $thread->favorites->each->delete();
        $thread->subscriptions->each->delete();
        $thread->activities->each->delete();
        Reputation::reduce($thread->user, Reputation::THREAD_WAS_PUBLISHED);
    }
}
