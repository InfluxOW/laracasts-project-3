<?php

namespace Tests\Feature;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    protected $user;
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->thread = factory(Thread::class)->raw(['user_id' => $this->user->id, 'g-recaptcha-response' => '1', 'image' => 'http://someurl.com/image.jpg']);
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->be($this->user);

        $this->get(route('threads.create'))
            ->assertOk();

        $this->verifyCaptcha();
        $this->post(route('threads.store'), $this->thread);
        $this->assertDatabaseHas('threads', Arr::except($this->thread, ['created_at', 'g-recaptcha-response']));
    }

    /** @test */
    public function a_thread_can_not_be_created_in_archived_channel()
    {
        $channel = factory(Channel::class)->create(['archived' => true]);
        $thread = factory(Thread::class)->raw([
            'user_id' => $this->user->id,
            'g-recaptcha-response' => '1',
            'image' => 'http://someurl.com/image.jpg',
            'channel_id' => $channel->id
            ]);

        $this->verifyCaptcha();
        $this->actingAs($this->user)
            ->post(route('threads.store'), $thread)
            ->assertSessionHasErrors('channel_id');
        $this->assertDatabaseMissing('channels', $channel->toArray());
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
    public function a_thread_can_be_updated_by_its_owner()
    {
        $thread = factory(Thread::class)->create(['user_id' => $this->user->id]);
        $attributes = ['title' => 'New Title', 'body' => str_repeat('New Test Body', 10)];

        $this->actingAs($this->user)->patch(route('threads.update', $thread), $attributes);
        $this->assertDatabaseHas('threads', $attributes);
    }

    /** @test */
    public function threads_slug_updates_according_to_the_title_update()
    {
        $thread = factory(Thread::class)->create(['user_id' => $this->user->id]);
        $slug = slugify("{$thread->title}_" . $thread->created_at->format('Y-m-d H:i'));
        $this->assertEquals($thread->slug, $slug);

        $attributes = ['title' => 'New Title', 'body' => str_repeat('New Test Body', 10)];

        $this->actingAs($this->user)->patch(route('threads.update', $thread), $attributes);
        $updatedSlug = slugify("{$thread->title}_" . $thread->created_at->format('Y-m-d H:i'));

        $this->assertEquals($thread->slug, $updatedSlug);
    }

    /** @test */
    public function a_thread_can_not_be_updated_by_unauthorized_users()
    {
        $thread = factory(Thread::class)->create();
        $attributes = ['title' => 'New Title', 'body' => str_repeat('New Test Body', 10)];

        $this->patch(route('threads.update', $thread), $attributes)
            ->assertRedirect(route('login'));

        $this->actingAs($this->user)->patch(route('threads.update', $thread), $attributes)
            ->assertForbidden();

        $this->assertDatabaseMissing('threads', $attributes);
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

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->verifyCaptcha();
        $this->thread['body'] = '';

        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->verifyCaptcha();
        $this->thread['title'] = '';

        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->verifyCaptcha();
        $this->thread['channel_id'] = '';

        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread)
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_valid_recaptcha_response()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->once();

        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread)
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_valid_image()
    {
        $this->thread['image'] = '';

        $this->actingAs($this->user)
            ->post(route('threads.store'), $this->thread)
            ->assertSessionHasErrors('image');
    }
}
