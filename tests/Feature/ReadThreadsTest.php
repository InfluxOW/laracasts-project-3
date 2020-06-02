<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->thread = factory(Thread::class)->create();
        $this->reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
    }

    /** @test */
    public function a_user_can_view_threads()
    {
        $response = $this->get(route('threads.index'));
        $response->assertOk()
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_view_a_specific_thread()
    {
        $response = $this->get(route('threads.show', $this->thread));

        $response->assertOk();
        // Thread itself
        $response->assertSee($this->thread->title)
                ->assertSee($this->thread->body);
        // Thread replies
        $response->assertSee($this->reply->body);
    }
}
