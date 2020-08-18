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
        $achievements = app('achievements')
            ->filter->qualifier($event->user)
            ->map->modelKey();
        $event->user->achievements()->sync($achievements);
    }
}
