<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_may_favorite_any_reply()
    {
        $reply = factory(Reply::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('favorites.store', ['reply', $reply->id]));
        $this->assertTrue($reply->isFavoritedBy($user));
    }

    /** @test */
    public function an_authenticated_user_may_favorite_any_thread()
    {
        $thread = factory(Thread::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('favorites.store', ['thread', $thread->id]));
        $this->assertTrue($thread->isFavoritedBy($user));
    }
}
