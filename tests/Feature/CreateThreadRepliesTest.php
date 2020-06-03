<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadRepliesTest extends TestCase
{
    protected $user;
    protected $thread;
    protected $reply;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->thread = factory(Thread::class)->create();
        $this->reply = factory(Reply::class)->raw();
    }

    /** @test */
    public function an_authenticated_user_may_add_replies()
    {
        $this->followingRedirects()
            ->actingAs($this->user)
            ->post(route('threads.replies.store', $this->thread), $this->reply);
        $this->assertDatabaseHas('replies', $this->reply);
    }

    /** @test */
    public function an_authenticated_user_may_not_add_replies()
    {
        $this->post(route('threads.replies.store', $this->thread), $this->reply);
        $this->assertDatabaseMissing('replies', $this->reply);
    }
}
