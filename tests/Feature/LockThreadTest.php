<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    protected $thread;
    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
        $this->admin = factory(User::class)->state('admin')->create();
    }

    /** @test */
    public function non_admins_can_not_lock_threads()
    {
        $this->actingAs($this->thread->user)->post(route('closed-thread.store', $this->thread))
            ->assertForbidden();
        $this->assertFalse($this->thread->fresh()->closed);
    }

    /** @test */
    public function admins_can_not_lock_threads()
    {
        $this->actingAs($this->admin)->post(route('closed-thread.store', $this->thread))
            ->assertOk();
        $this->assertTrue($this->thread->fresh()->closed);
    }

    /** @test */
    public function users_can_not_post_comments_in_a_closed_thread()
    {
        $this->thread->close();
        $this->actingAs($this->thread->user)->post(route('threads.replies.store', [$this->thread->channel, $this->thread]), ['body' => 'It should not be posted'])
            ->assertStatus(422);
        $this->assertDatabaseCount('replies', 0);
    }
}
