<?php

namespace App\Achievements;

use App\User;

class FirstThousandPoints extends AchievementType
{
    public $name = 'First Thousand Points';
    public $description = 'Earned once you have 1000 reputation points.';
    public $icon = 'first-thousand.svg';

    public function qualifier(User $user): bool
    {
        return $user->reputation >= 1000;
    }
}
