<?php

namespace App\Achievements;

use App\User;

class OneYearMember extends AchievementType
{
    public $name = 'One Year Member';
    public $description = 'Earned once you have been with Forum for 1 year.';
    public $icon = 'https://laracasts-project-3.s3.eu-west-3.amazonaws.com/achievements/one-year-member.png';

    public function qualifier(User $user): bool
    {
        return $user->created_at->greaterThanOrEqualTo(now()->subYear());
    }
}
