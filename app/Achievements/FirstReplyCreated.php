<?php

namespace App\Achievements;

use App\User;

class FirstReplyCreated extends AchievementType
{
    public $name = 'Welcome To The Community';
    public $description = 'Earned after your first post on the Forum';
    public $icon = 'https://laracasts-project-3.s3.eu-west-3.amazonaws.com/achievements/first-comment.png';

    public function qualifier(User $user): bool
    {
        return $user->replies_count > 0;
    }

    public function level()
    {
        return 'beginner';
    }
}
