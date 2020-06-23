<?php

namespace App\Traits;

use App\Subscription;

trait Subscribable
{
    public function subscribable()
    {
        return $this->hasMany(Subscription::class, 'subscribable_id');
    }
}
