<?php

namespace Tests\Feature;

use App\Achievement;
use App\Reputation;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    /** @test */
    public function an_achievement_can_be_assigned_to_any_user()
    {
        $user = factory(User::class)->create();
        $achievement = factory(Achievement::class)->create();
        $achievement->awardTo($user);

        $this->assertCount(1, $user->achievements);
        $this->assertTrue($user->achievements[0]->is($achievement));
    }

    /** @test */
    public function an_achievement_is_unlocked_once_a_users_reputation_points_pass_1000()
    {
        Reputation::award($user = factory(User::class)->create(), 1001);

        $this->assertCount(1, $user->achievements);
    }

    /** @test */
    public function an_achievement_is_unlocked_once_a_year_has_passed_since_user_registration()
    {
        $user = factory(User::class)->create();
        Carbon::setTestNow(now()->subYear());
        $this->assertCount(1, $user->achievements);
    }
}
