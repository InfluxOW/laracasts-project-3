<?php

namespace App\Providers;

use App\Http\View\Composers\ThreadsCard;
use App\Http\View\Composers\ThreadsFiltration;
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
        View::composer(['components.threads.card'], ThreadsCard::class);
    }
}
