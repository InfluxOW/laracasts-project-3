<?php

namespace App\Providers;

use App\Channel;
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
        View::composer(['*'], function ($view) {
            // $view->with('channels', Channel::all());
        });

        View::composer(['components.threads.filtration'], function ($view) {
            $sorts = ['replies' => 'Less Commented', '-replies' => 'Most Commented', 'views' => 'Less Viewed', '-views' => 'Most Viewed'];
            $currentSort = request()->query('sort');
            $view->with('sorts', $sorts);
            $view->with('currentSort', $currentSort);
        });
    }
}
