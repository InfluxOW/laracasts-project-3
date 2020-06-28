<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Redis::del('trending_threads');
    }

    /** @test */
    public function it_increments_views_count_each_time_it_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));

        $thread = factory(Thread::class)->create();
        $this->get($thread->link);

        $trending = Redis::zrevrange('trending_threads', 0, -1);
        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, json_decode($trending[0], false)->title);
    }
}
