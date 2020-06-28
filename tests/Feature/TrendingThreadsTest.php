<?php

namespace Tests\Feature;

use App\Helpers\Trending;
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

        $this->trending = new Trending();
        $this->trending->reset();
    }

    /** @test */
    public function it_increments_views_count_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = factory(Thread::class)->create();
        $this->get($thread->link);

        $trending = $this->trending->get();
        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
