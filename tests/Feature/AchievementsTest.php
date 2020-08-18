<?php

namespace Tests\Feature;

use App\Reputation;
use App\User;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    /** @test */
    public function an_achievement_is_unlocked_once_a_users_reputation_points_pass_1000()
    {
        $user = factory(User::class)->create();
        Reputation::award($user, 1001);

        $this->assertCount(1, $user->achievements);

    }
}
