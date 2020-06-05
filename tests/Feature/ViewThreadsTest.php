<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewThreadsTest extends TestCase
{
    protected $user;
    protected $thread;
    protected $reply;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
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
        $response = $this->get(route('threads.show', [$this->thread->channel, $this->thread]));

        $response->assertOk();
        $response->assertSee($this->thread->title)
                ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $threadInChannel = $this->thread;
        $threadNotInChannel = factory(Thread::class)->create();

        $this->get(route('threads.filter', $threadInChannel->channel))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
