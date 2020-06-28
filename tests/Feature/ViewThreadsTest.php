<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ViewThreadsTest extends TestCase
{
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
        Config::set('visits.remember_ip', 0);
        Config::set('visits.ignore_crawlers', false);
        visits(Thread::class)->reset();
    }

    /** @test */
    public function a_user_can_view_threads()
    {
        $response = $this->get(route('threads.index'));
        $response->assertOk()
            ->assertSee($this->thread->title);
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

        for ($i = 0; $i < 3; $i++) {
            $this->actingAs($threadOne->user)->get(route('threads.show', [$threadOne->channel, $threadOne]));
        }
        for ($i = 0; $i < 1; $i++) {
            $this->actingAs($threadTwo->user)->get(route('threads.show', [$threadTwo->channel, $threadTwo]));
        }
        for ($i = 0; $i < 2; $i++) {
            $this->actingAs($threadThree->user)->get(route('threads.show', [$threadThree->channel, $threadThree]));
        }

        $response = $this->getJson(route('threads.index', ['sort' => '-views']))->json();
        $views = array_column($response['data'], 'views_count');
        $this->assertEquals([3, 2, 1], $views);
    }

    /** @test */
    public function a_user_can_sort_threads_by_comments_count()
    {
        $threadOne = $this->thread;
        factory(Reply::class, 2)->create(['thread_id' => $threadOne->id]);

        $threadTwo = factory(Thread::class)->create();
        factory(Reply::class, 3)->create(['thread_id' => $threadTwo->id]);

        $threadThree = factory(Thread::class)->create();
        factory(Reply::class, 1)->create(['thread_id' => $threadThree->id]);

        $response = $this->getJson(route('threads.index', ['sort' => '-replies']))->json();
        $replies = array_column($response['data'], 'replies_count');
        $this->assertEquals([3, 2, 1], $replies);
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

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $replies = factory(Reply::class, 20)->create(['thread_id' => $this->thread->id]);
        $response = $this->getJson(route('threads.replies.index', [$this->thread->channel, $this->thread]))->json();

        $this->assertCount(15, $response['data']);
        $this->assertEquals(20, $response['total']);
    }
}
