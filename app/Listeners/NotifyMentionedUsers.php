<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Notifications\ThreadWasUpdated;
use App\Notifications\YouWereMentioned;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        $users = User::whereIn('username', $event->reply->mentionedUsers())->get();
        $users->each(function ($user) use ($event) {
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
