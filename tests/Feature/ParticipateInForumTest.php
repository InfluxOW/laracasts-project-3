<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_may_add_replies()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->raw();

        $this->followingRedirects()
            ->actingAs($user)->post(route('threads.replies.store', $thread), $reply)
            ->assertSee($reply['body']);
    }

    /** @test */
    public function an_authenticated_user_may_not_add_replies()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->raw();

        $response = $this->post(route('threads.replies.store', $thread), $reply);
        $response->assertRedirect();
    }
}
