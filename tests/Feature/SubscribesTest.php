<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribesTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_can_subscribe_to_a_thread()
    {
        $thread = factory(Thread::class)->create();
        $this->actingAs($this->user)->post(route('subscriptions.store', [$thread->getMorphClass(), $thread->getKey()]));
        $this->assertCount(1, $this->user->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_thread()
    {
        $thread = factory(Thread::class)->create();
        $this->actingAs($this->user)->post(route('subscriptions.store', [$thread->getMorphClass(), $thread->getKey()]));
        $this->actingAs($this->user)->delete(route('subscriptions.destroy', [$thread->getMorphClass(), $thread->getKey()]));
        $this->assertCount(0, $this->user->subscriptions);
    }
}
