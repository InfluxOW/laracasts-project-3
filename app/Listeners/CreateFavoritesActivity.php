<?php

namespace App\Listeners;

use App\Reply;
use App\Thread;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Overtrue\LaravelFavorite\Favorite;
use Spatie\Activitylog\Models\Activity;

class CreateFavoritesActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (isset($event->favorite->favoriteable)) {
            activity('favorites_log')
                ->causedBy(request()->user())
                ->performedOn($event->favorite->favoriteable)
                ->withProperties([
                    'favoriteable_type' => strtolower(class_basename($event->favorite->favoriteable)),
                    'favoriteable.link' => $event->favorite->favoriteable->link,
                    'favoriteable.main' => $event->favorite->favoriteable->title ?? $event->favorite->favoriteable->body
                ])
                ->log(strtolower(class_basename($event)));
        }
    }
}
