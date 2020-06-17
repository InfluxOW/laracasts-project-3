<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /** @test */
    public function a_user_has_a_profile()
    {
        $user = factory(User::class)->create();

        $this->get(route('profiles.show', $user))
            ->assertOk();
    }

    /** @test */
    public function a_user_has_actions()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $channel = factory(Channel::class)->create();
        $thread = factory(Thread::class)->create(['user_id' => $user->id, 'channel_id' => $channel->id]);
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);

        $this->assertCount(3, $user->actions);
        $this->assertInstanceOf(Channel::class, $user->actions->get(0)->subject);
        $this->assertInstanceOf(Thread::class, $user->actions->get(1)->subject);
        $this->assertInstanceOf(Reply::class, $user->actions->get(2)->subject);
    }
}
