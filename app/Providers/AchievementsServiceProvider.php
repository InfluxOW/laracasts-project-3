<?php

namespace App\Providers;

use App\Achievements\FirstThousandPoints;
use App\Achievements\OneYearMember;
use App\Events\UserEarnedReputation;
use App\Listeners\AwardAchievements;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    protected $achievements = [
        FirstThousandPoints::class,
        OneYearMember::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function () {
            return collect($this->achievements)
                ->map(function($achievement) {
                    return new $achievement;
                });
        });
    }

    public function boot()
    {
        Event::listen(UserEarnedReputation::class, AwardAchievements::class);
    }
}
