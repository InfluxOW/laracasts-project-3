<?php

namespace App\Listeners;

use App\Events\UserEarnedReputation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAchievements
{
    /**
     * Handle the event.
     *
     * @param  UserEarnedReputation  $event
     * @return void
     */
    public function handle(UserEarnedReputation $event)
    {
        $event->user->syncAchievements();
    }
}
