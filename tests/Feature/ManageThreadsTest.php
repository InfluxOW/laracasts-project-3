<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThreadsTest extends TestCase
{
    protected $user;
    protected $thread;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->thread = factory(Thread::class)->raw(['user_id' => $this->user->id]);
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread);
        $this->assertDatabaseHas('threads', $this->thread);
    }

    /** @test */
    public function guest_can_not_create_new_forum_threads()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        $this->post(route('threads.store'), $this->thread)
            ->assertRedirect(route('login'));
        $this->assertDatabaseMissing('threads', $this->thread);
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $attributes = factory(Thread::class)->raw(['body' => '']);

        $this->actingAs($this->user)
            ->post(route('threads.store'), $attributes)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $attributes = factory(Thread::class)->raw(['title' => '']);

        $this->actingAs($this->user)
            ->post(route('threads.store'), $attributes)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $attributes = factory(Thread::class)->raw(['channel_id' => '']);

        $this->actingAs($this->user)
            ->post(route('threads.store'), $attributes)
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_can_be_deleted_by_its_owner()
    {
        $thread = factory(Thread::class)->create();
        $attributes = Arr::only($thread->toArray(), ['id', 'body', 'user_id', 'channel_id']);

        $this->assertDatabaseHas('threads', $attributes);
        $this->actingAs($thread->user)->delete(route('threads.destroy', $thread));
        $this->assertDatabaseMissing('threads', $attributes);
    }

    /** @test */
    public function a_thread_can_not_be_deleted_by_unauthorized_users()
    {
        $thread = factory(Thread::class)->create();
        $attributes = Arr::only($thread->toArray(), ['id', 'body', 'user_id', 'channel_id']);

        $this->delete(route('threads.destroy', $thread))
            ->assertRedirect(route('login'));
        $this->assertDatabaseHas('threads', $attributes);

        $this->actingAs($this->user)->delete(route('threads.destroy', $thread))
            ->assertForbidden();
        $this->assertDatabaseHas('threads', $attributes);
    }
}
