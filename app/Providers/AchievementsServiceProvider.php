<?php

namespace App\Providers;

use App\Achievements\FirstBestReplyAwarded;
use App\Achievements\FirstReplyCreated;
use App\Achievements\FirstThousandPoints;
use App\Achievements\FirstThreadCreated;
use App\Achievements\OneYearMember;
use App\Events\UserEarnedReputation;
use App\Listeners\AwardAchievements;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    protected $achievements = [
        FirstThousandPoints::class,
        OneYearMember::class,
        FirstReplyCreated::class,
        FirstThreadCreated::class,
        FirstBestReplyAwarded::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('achievements', function () {
            return Cache::rememberForever('achievements', function() {
                return collect($this->achievements)->map(function($achievement) {
                        return new $achievement;
                    });
            });
        });
    }

    public function boot()
    {
        Event::listen(UserEarnedReputation::class, AwardAchievements::class);
    }
}
