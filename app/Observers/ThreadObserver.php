<?php

namespace App\Observers;

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
        $thread->update(['slug' => slugify($thread->title)]);
        $thread->enableLogging();
    }

    /**
     * Handle the thread "updated" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function updated(Thread $thread)
    {
        //
    }

    /**
     * Handle the thread "updating" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function updating(Thread $thread)
    {
        //
    }

    /**
     * Handle the thread "deleted" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function deleted(Thread $thread)
    {
        //
    }

    /**
     * Handle the thread "restored" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function restored(Thread $thread)
    {
        //
    }

    /**
     * Handle the thread "force deleted" event.
     *
     * @param  \App\Thread  $thread
     * @return void
     */
    public function forceDeleted(Thread $thread)
    {
        //
    }
}
