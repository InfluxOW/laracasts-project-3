<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

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
        $this->actingAs($this->thread->user)
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
    public function an_authorized_user_can_edit_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
        $attributes = ['body' => 'new body'];

        $this->actingAs($reply->user)->patch(route('threads.replies.update', $reply), $attributes);
        $this->assertDatabaseHas('replies', $attributes);
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_replies()
    {
        $user = factory(User::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
        $attributes = ['body' => 'new body'];

        $this->patch(route('threads.replies.update', $reply), $attributes)
            ->assertRedirect(route('login'));
        $this->actingAs($user)->patch(route('threads.replies.update', $reply), $attributes)
            ->assertForbidden();
        $this->assertDatabaseMissing('replies', $attributes);
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
