<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();
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
        factory(Reply::class, 10)->create();

        $this->assertInstanceOf(Reply::class, $this->thread->replies->first());
        $this->assertCount(10, $this->thread->replies);
    }
}
