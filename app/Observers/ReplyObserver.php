<?php

namespace App\Observers;

use App\Reply;

class ReplyObserver
{
    /**
     * Handle the reply "created" event.
     *
     * @param  \App\Reply  $reply
     * @return void
     */
    public function created(Reply $reply)
    {
        //
    }

    /**
     * Handle the reply "updated" event.
     *
     * @param  \App\Reply  $reply
     * @return void
     */
    public function updated(Reply $reply)
    {
        //
    }

    /**
     * Handle the reply "deleted" event.
     *
     * @param  \App\Reply  $reply
     * @return void
     */
    public function deleted(Reply $reply)
    {
        $reply->favorites->each->delete();
    }

    /**
     * Handle the reply "restored" event.
     *
     * @param  \App\Reply  $reply
     * @return void
     */
    public function restored(Reply $reply)
    {
        //
    }

    /**
     * Handle the reply "force deleted" event.
     *
     * @param  \App\Reply  $reply
     * @return void
     */
    public function forceDeleted(Reply $reply)
    {
        //
    }
}
