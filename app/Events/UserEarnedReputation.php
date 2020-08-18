<?php

namespace App\Events;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserEarnedReputation
{
    use Dispatchable, SerializesModels;

    public User $user;
    public $points;
    public $totalPoints;

    public function __construct(User $user, $points, $totalPoints)
    {
        $this->user = $user;
        $this->points = $points;
        $this->totalPoints = $totalPoints;
    }
}
