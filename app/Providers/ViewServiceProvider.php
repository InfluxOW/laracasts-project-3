<?php

namespace App\Providers;

use App\Channel;
use App\Http\View\Composers\ThreadsCard;
use App\Http\View\Composers\ThreadsFiltration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['components.threads.filtration'], ThreadsFiltration::class);
        View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function() {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });
    }
}
