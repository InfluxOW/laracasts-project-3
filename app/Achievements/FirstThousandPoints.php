<?php

namespace App\Achievements;

use App\User;

class FirstThousandPoints extends AchievementType
{
    public $name = 'First Thousand Points';
    public $description = 'Earned once you have 1000 reputation points.';
    public $icon = 'https://laracasts-project-3.s3.eu-west-3.amazonaws.com/achievements/first-thousand-points.png';

    public function qualifier(User $user): bool
    {
        return $user->reputation >= 1000;
    }

    public function level()
    {
        return 'advanced';
    }
}
