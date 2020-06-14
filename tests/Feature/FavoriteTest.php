<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /** @test */
    public function a_guest_can_not_favorite_anything()
    {
        $reply = factory(Reply::class)->create();
        $this->post(route('favorites.store', ['reply', $reply->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $reply = factory(Reply::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('favorites.store', ['reply', $reply->id]));
        $this->assertTrue($reply->isFavoritedBy($user));

        $this->actingAs($user)->post(route('favorites.store', ['reply', $reply->id]));
        $this->assertFalse($reply->isFavoritedBy($user));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_thread()
    {
        $thread = factory(Thread::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('favorites.store', ['thread', $thread->id]));
        $this->assertTrue($thread->isFavoritedBy($user));

        $this->actingAs($user)->post(route('favorites.store', ['thread', $thread->id]));
        $this->assertFalse($thread->isFavoritedBy($user));
    }
}
