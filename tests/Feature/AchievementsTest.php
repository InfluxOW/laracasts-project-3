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
        Carbon::setTestNow(now()->addYear());

        $this->artisan('achievements:sync');
        $this->assertCount(1, $user->achievements);
    }

    /** @test */
    public function it_can_be_seeded_for_all_users_as_a_console_command()
    {
        $users = factory(User::class, 2)->create();

        $john = $users->first();
        $john->increment('reputation', 1001);
        $jane = $users->second();
        $jane->increment('reputation', 1001);

        $this->assertCount(0, $john->achievements);
        $this->assertCount(0, $jane->achievements);

        $this->artisan('achievements:sync');

        $this->assertCount(1, $john->fresh()->achievements);
        $this->assertCount(1, $jane->fresh()->achievements);
    }
}
