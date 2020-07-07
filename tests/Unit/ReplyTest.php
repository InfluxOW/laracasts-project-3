<?php

namespace Tests\Unit;

use App\Channel;
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

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = factory(Reply::class)->create(['body' => '@jane and @pyotr, hello!']);
        $this->assertEquals(['jane', 'pyotr'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_knows_if_it_is_the_best_reply()
    {
        $this->assertFalse($this->reply->isBest());

        $this->reply->markAsBest();

        $this->assertTrue($this->reply->isBest());
    }

    /** @test */
    public function a_reply_body_is_sanitized_automatically()
    {
        $reply = factory(Reply::class)->make(['body' => "<script>alert('bad')</script><h1>Test</h1>"]);
        $this->assertEquals($reply->body, "<h1>Test</h1>");
    }
}
