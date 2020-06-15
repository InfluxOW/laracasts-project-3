<?php

namespace App\Providers;

use App\Channel;
use App\Observers\ChannelObserver;
use App\Observers\ThreadObserver;
use App\Thread;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
        Relation::morphMap([
            'reply' => 'App\Reply',
            'thread' => 'App\Thread',
            'user' => 'App\User',
            'channel' => 'App\Channel'
        ]);

        Thread::observe(ThreadObserver::class);
        Channel::observe(ChannelObserver::class);
    }
}
