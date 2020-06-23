<?php

namespace Tests\Unit;

use App\Reply;
use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    public function it_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    /** @test */
    public function it_has_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
        $this->assertCount(1, $this->thread->replies);
        $this->assertTrue($this->thread->replies->contains($reply));
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $this->actingAs($this->thread->user);

        $this->thread->addReply(['body' => 'test reply']);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    /** @test */
    public function it_can_be_subscribed_to()
    {
        $user = factory(User::class)->create();
        $user->subscribeTo($this->thread);
        $subscribable = $user->subscriptions->first()->subscribable;
        $this->assertCount(1, $user->subscriptions);
        $this->assertEquals([$subscribable->id, $subscribable->title], [$this->thread->id, $this->thread->title]);
    }

    /** @test */
    public function it_can_be_unsubscribed_from()
    {
        $user = factory(User::class)->create();
        $user->subscribeTo($this->thread);
        $user->unsubscribeFrom($this->thread);
        $this->assertCount(0, $user->subscriptions);
    }
}
