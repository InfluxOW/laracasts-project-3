<?php

namespace App\Traits;

use App\Subscription;

trait Subscriber
{
    public function subscribeTo($model)
    {
        $subscription = new Subscription();
        $subscription->user()->associate($this);
        $subscription->subscribable()->associate($model);

        return $this->subscriptions()->save($subscription);
    }

    public function unsubscribeFrom($model)
    {
        $subscription = $this->subscriptions()
            ->where('subscribable_id', $model->getKey())
            ->where('subscribable_type', $model->getMorphClass())
            ->firstOrFail();

        return $subscription->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
