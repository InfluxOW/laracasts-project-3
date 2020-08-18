<?php

namespace App\Achievements;

use App\User;

class FirstThreadCreated extends AchievementType
{
    public $name = 'Talkative';
    public $description = 'Earned after your first thread on the Forum';
    public $icon = 'https://laracasts-project-3.s3.eu-west-3.amazonaws.com/achievements/first-thread.jpg';

    public function qualifier(User $user): bool
    {
        return $user->threads_count > 0;
    }
}
