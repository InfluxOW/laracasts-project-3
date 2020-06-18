<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
                    'favoriteable' => $event->favorite->favoriteable->withoutRelations()
                ])
                ->log(strtolower(class_basename($event)));
        }
    }
}
