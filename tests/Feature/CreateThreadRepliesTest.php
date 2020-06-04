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

        $this->thread = factory(Thread::class)->create();
        $this->reply = collect(factory(Reply::class)->raw())->only('body')->toArray();
    }

    /** @test */
    public function an_authenticated_user_may_add_replies()
    {
        $this->followingRedirects()
            ->actingAs($this->thread->user)
            ->post(route('threads.replies.store', [$this->thread->channel, $this->thread]), $this->reply);
        $this->assertDatabaseHas('replies', $this->reply);
    }

    /** @test */
    public function an_guest_may_not_add_replies()
    {
        $this->post(route('threads.replies.store', [$this->thread->channel, $this->thread]), $this->reply);
        $this->assertDatabaseMissing('replies', $this->reply);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $attributes = ['body' => ''];

        $this->actingAs($this->thread->user)
            ->post(
                route('threads.replies.store', [$this->thread->channel, $this->thread]),
                $attributes
            )->assertSessionHasErrors('body');
    }
}
