<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThreadRepliesTest extends TestCase
{
    protected $thread;
    protected $reply;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
        $this->reply = collect(factory(Reply::class)->raw())->only('body')->toArray();
    }

    /** @test */
    public function an_authenticated_user_can_add_replies()
    {
        $this->followingRedirects()
            ->actingAs($this->thread->user)
            ->post(route('threads.replies.store', [$this->thread->channel, $this->thread]), $this->reply);
        $this->assertDatabaseHas('replies', $this->reply);
    }

    /** @test */
    public function a_guest_cannot_add_replies()
    {
        $this->post(route('threads.replies.store', [$this->thread->channel, $this->thread]), $this->reply);
        $this->assertDatabaseMissing('replies', $this->reply);
    }

    /** @test */
    public function an_authorized_user_can_delete_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
        $this->actingAs($reply->user)
            ->delete(route('threads.replies.destroy', $reply));
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_replies()
    {
        $user = factory(User::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->delete(route('threads.replies.destroy', $reply))
            ->assertRedirect(route('login'));
        $this->actingAs($user)->delete(route('threads.replies.destroy', $reply))
            ->assertForbidden();
        $this->assertDatabaseHas('replies', ['id' => $reply->id]);

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
