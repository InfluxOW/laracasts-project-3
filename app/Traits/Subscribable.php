<?php

namespace App\Traits;

use App\Subscription;

trait Subscribable
{
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscribable_id');
    }
}
