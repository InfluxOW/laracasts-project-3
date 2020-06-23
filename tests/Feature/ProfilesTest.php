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
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_has_a_profile()
    {
        $this->get(route('profiles.show', $this->user))
            ->assertOk();
    }

    /** @test */
    public function a_user_has_actions()
    {
        $this->be($this->user);

        $channel = factory(Channel::class)->create();
        $thread = factory(Thread::class)->create(['channel_id' => $channel->id, 'user_id' => $this->user->id]);
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $this->user->id]);
        $this->user->favorite($reply);
        $this->user->subscribeTo($thread);

        $this->assertCount(4, $this->user->actions);
        $this->get(route('profiles.show', $this->user))
            ->assertOk();
    }
}
