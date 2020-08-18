<?php

namespace App\Providers;

use App\Events\BestReplyCreated;
use App\Events\ReplyCreated;
use App\Events\UserEarnedReputation;
use App\Listeners\AwardAchievements;
use App\Listeners\CreateFavoritesActivity;
use App\Listeners\ManageReputation;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifyThreadSubscribers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelFavorite\Events\Favorited;
use Overtrue\LaravelFavorite\Events\Unfavorited;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Favorited::class => [
            CreateFavoritesActivity::class,
            ManageReputation::class
        ],
        Unfavorited::class => [
            CreateFavoritesActivity::class,
            ManageReputation::class
        ],
        ReplyCreated::class => [
            NotifyThreadSubscribers::class,
            NotifyMentionedUsers::class
        ],
        BestReplyCreated::class => [
            ManageReputation::class
        ],
        UserEarnedReputation::class => [
            AwardAchievements::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
