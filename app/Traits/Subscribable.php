<?php

namespace App\Traits;

trait Subscribable
{
    public function subscribable()
    {
        return $this->hasMany(Subscription::class, 'subscribable');
    }
}
