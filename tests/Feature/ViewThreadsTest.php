<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;

class ViewThreadsTest extends TestCase
{
    protected $thread;

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

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $threadOfAnotherUser = factory(Thread::class)->create();

        $this->get(route('threads.index', ['filter[user.username]' => $this->thread->user->username]))
            ->assertSee($this->thread->title)
            ->assertDontSee($threadOfAnotherUser->title);
    }

    /** @test */
    public function a_user_can_sort_threads_by_views_count()
    {
        $threadOne = $this->thread;
        $threadTwo = factory(Thread::class)->create();
        $threadThree = factory(Thread::class)->create();

        for ($i = 0; $i < 10; $i++) {
            $this->get(route('threads.show', [$threadOne->channel, $threadOne]));
        }
        for ($i = 0; $i < 5; $i++) {
            $this->get(route('threads.show', [$threadTwo->channel, $threadTwo]));
        }
        for ($i = 0; $i < 15; $i++) {
            $this->get(route('threads.show', [$threadThree->channel, $threadThree]));
        }

        $response = $this->getJson(route('threads.index', ['sort' => '-views']))->json();
        $views = array_column($response['data'], 'views_count');
        $this->assertEquals([15, 10, 5], $views);
    }

    /** @test */
    public function a_user_can_sort_threads_by_comments_count()
    {
        $threadOne = $this->thread;
        factory(Reply::class, 5)->create(['thread_id' => $threadOne->id]);

        $threadTwo = factory(Thread::class)->create();
        factory(Reply::class, 15)->create(['thread_id' => $threadTwo->id]);

        $threadThree = factory(Thread::class)->create();
        factory(Reply::class, 10)->create(['thread_id' => $threadThree->id]);

        $response = $this->getJson(route('threads.index', ['sort' => '-replies']))->json();
        $replies = array_column($response['data'], 'replies_count');
        $this->assertEquals([15, 10, 5], $replies);
    }

    /** @test */
    public function a_user_can_sort_threads_by_favorites_count()
    {
        $threadOne = $this->thread;
        $this->actingAs($threadOne->user)->post(route('favorites.store', ['thread', $threadOne->id]));

        $threadTwo = factory(Thread::class)->create();
        $this->actingAs($threadOne->user)->post(route('favorites.store', ['thread', $threadTwo->id]));
        $this->actingAs($threadTwo->user)->post(route('favorites.store', ['thread', $threadTwo->id]));

        $threadThree = factory(Thread::class)->create();
        $this->actingAs($threadOne->user)->post(route('favorites.store', ['thread', $threadThree->id]));
        $this->actingAs($threadTwo->user)->post(route('favorites.store', ['thread', $threadThree->id]));
        $this->actingAs($threadThree->user)->post(route('favorites.store', ['thread', $threadThree->id]));

        $response = $this->getJson(route('threads.index', ['sort' => '-favorites']))->json();
        $replies = array_column($response['data'], 'favorites_count');
        $this->assertEquals([3, 2, 1], $replies);
    }
}
