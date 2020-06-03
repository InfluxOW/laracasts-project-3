<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    protected $reply;

    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();
        factory(Thread::class)->create();
        $this->reply = factory(Reply::class)->create();
    }

    /** @test */
    public function it_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->reply->user);
    }

    /** @test */
    public function it_has_a_thread()
    {
        $this->assertInstanceOf(Thread::class, $this->reply->thread);
    }
}
