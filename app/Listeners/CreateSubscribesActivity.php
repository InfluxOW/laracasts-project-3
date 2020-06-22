<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSubscribesActivity
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
        if (isset($event->subscription->subscribable)) {
            activity('subscriptions_log')
                ->causedBy(request()->user())
                ->performedOn($event->subscription->subscribable)
                ->withProperties([
                    'subscribable_type' => strtolower(class_basename($event->subscription->subscribable)),
                    'subscribable' => $event->subscription->subscribable->withoutRelations()
                ])
                ->log(strtolower(class_basename($event)));
        }
    }
}
