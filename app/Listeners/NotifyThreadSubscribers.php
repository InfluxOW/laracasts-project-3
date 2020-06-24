<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyThreadSubscribers
{
    /**
     * Handle the event.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        $event->reply->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user->id)
            ->each( function ($subscription) use ($event) {
                $subscription->user->notify(new ThreadWasUpdated($event->reply));
            });
    }
}
