<?php

namespace App\Traits;

use App\Subscription;
use Illuminate\Database\Eloquent\Builder;

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

    public function isSubscribedTo($model)
    {
        return $this->subscriptions()->whereHasMorph('subscribable', get_class($model), function (Builder $query) use ($model) {
            return $query->where('subscribable_id', $model->getKey())->where('subscribable_type', $model->getMorphClass());
        })->exists();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
