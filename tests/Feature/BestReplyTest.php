<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    /** @test */
    public function a_thread_creator_can_mark_any_reply_as_the_best_reply()
    {
        $thread = factory(Thread::class)->create();
        $replies = factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $this->actingAs($thread->user)->post(route('best-reply.store', $replies->first()));
        $this->assertTrue($replies->fresh()->first()->isBest());
        $this->assertFalse($replies->fresh()->second()->isBest());
    }

    /** @test */
    public function only_thread_creator_can_mark_reply_as_the_best()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);
        $this->actingAs($reply->user)->post(route('best-reply.store', $reply))
            ->assertForbidden();
        $this->assertFalse($reply->isBest());
    }
}
