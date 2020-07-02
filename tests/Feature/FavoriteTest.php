<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    protected $thread;
    protected $reply;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reply = factory(Reply::class)->create();
        $this->thread = factory(Thread::class)->create();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_guest_can_not_favorite_anything()
    {
        $this->post(route('favorites.store', ['reply', $this->reply->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->actingAs($this->user)->post(route('favorites.store', ['reply', $this->reply->id]));
        $this->assertTrue($this->reply->isFavoritedBy($this->user));

        $this->actingAs($this->user)->delete(route('favorites.destroy', ['reply', $this->reply->id]));
        $this->assertFalse($this->reply->isFavoritedBy($this->user));
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->user->favorite($this->reply);

        $this->actingAs($this->user)->delete(route('favorites.destroy', ['reply', $this->reply->id]));
        $this->assertFalse($this->reply->isFavoritedBy($this->user));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_thread()
    {
        $this->actingAs($this->user)->post(route('favorites.store', ['thread', $this->thread->id]));
        $this->assertTrue($this->thread->isFavoritedBy($this->user));

        $this->actingAs($this->user)->delete(route('favorites.destroy', ['thread', $this->thread->id]));
        $this->assertFalse($this->thread->isFavoritedBy($this->user));
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_any_thread()
    {
        $this->user->favorite($this->thread);

        $this->actingAs($this->user)->delete(route('favorites.destroy', ['thread', $this->thread->id]));
        $this->assertFalse($this->thread->isFavoritedBy($this->user));
    }
}
