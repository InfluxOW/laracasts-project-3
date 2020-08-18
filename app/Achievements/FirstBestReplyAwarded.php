<?php

namespace App\Achievements;

use App\User;

class FirstBestReplyAwarded extends AchievementType
{
    public $name = 'Pay It Forward';
    public $description = "Earned once you receive your first 'Best Reply' award on the Forum";
    public $icon = 'https://laracasts-project-3.s3.eu-west-3.amazonaws.com/achievements/first-best-reply.png';

    public function qualifier(User $user): bool
    {
        return $user->replies->filter->isBest->count() > 0;
    }
}
