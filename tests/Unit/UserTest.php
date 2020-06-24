<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
        $this->thread = factory(Thread::class)->create(['user_id' => $this->user->id]);
        $this->reply = factory(Reply::class)->create(['user_id' => $this->user->id, 'thread_id' => $this->thread->id]);
    }

    /** @test */
    public function it_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->user->replies);
        $this->assertCount(1, $this->user->replies);
        $this->assertTrue($this->user->replies->contains($this->reply));
    }

    /** @test */
    public function it_has_threads()
    {
        $this->assertInstanceOf(Collection::class, $this->user->threads);
        $this->assertCount(1, $this->user->threads);
        $this->assertTrue($this->user->threads->contains($this->thread));
    }

    /** @test */
    public function it_has_subscriptions()
    {
        $subscription = $this->user->subscribeTo($this->thread);
        $this->assertInstanceOf(Collection::class, $this->user->subscriptions);
        $this->assertCount(1, $this->user->subscriptions);
        $this->assertTrue($this->user->subscriptions->contains($subscription));
    }

    /** @test */
    public function it_has_favorites()
    {
        $this->user->favorite($this->thread);
        $this->assertInstanceOf(Collection::class, $this->user->favorites);
        $this->assertCount(1, $this->user->favorites);
    }

    /** @test */
    public function it_has_actions()
    {
        $this->assertInstanceOf(Collection::class, $this->user->actions);
        $this->assertCount(2, $this->user->actions);
        $this->assertInstanceOf(Activity::class, $this->user->actions->first());
    }
}
