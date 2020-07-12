<?php

namespace App\Listeners;

use App\Reputation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ManageReputation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        switch (class_basename($event)) {
            case 'Favorited':
                Reputation::award($event->favorite->favoriteable->user, Reputation::REPLY_FAVORITED);
                break;
            case 'Unfavorited':
                Reputation::reduce($event->favorite->favoriteable->user, Reputation::REPLY_FAVORITED);
                break;
            case 'BestReplyCreated':
                if (! is_null($event->reply->thread->best_reply_id)) {
                    Reputation::reduce($event->reply->thread->bestReply->user, Reputation::BEST_REPLY_AWARDED);
                }
                Reputation::award($event->reply->user, Reputation::BEST_REPLY_AWARDED);
                break;
        }
    }
}
