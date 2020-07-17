<?php

namespace App\Observers;

use App\Events\ReplyCreated;
use App\Reply;
use App\Reputation;

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
        event(new ReplyCreated($reply));
        Reputation::award($reply->user, Reputation::REPLY_POSTED);
    }

    public function deleting(Reply $reply)
    {
        if ($reply->isBest()) {
            $reply->thread->update(['best_reply_id' => null]);
        }
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
        $reply->activities->each->delete();
        Reputation::reduce($reply->user, Reputation::REPLY_POSTED);
    }
}
