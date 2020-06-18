<?php

namespace App\Providers;

use App\Listeners\CreateFavoritesActivity;
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
            CreateFavoritesActivity::class
        ],
        Unfavorited::class => [
            CreateFavoritesActivity::class
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
