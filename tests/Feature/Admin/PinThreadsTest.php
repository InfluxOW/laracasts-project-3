<?php

namespace Tests\Feature\Admin;

use App\Thread;
use Tests\TestCase;

class PinThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory('App\User')->state('admin')->create();
    }

    /** @test */
    public function administrators_can_pin_threads()
    {
        $thread = factory(Thread::class)->create();

        $this->actingAs($this->admin)
            ->post(route('pinned-threads.store', $thread));

        $this->assertTrue($thread->fresh()->pinned, 'Failed asserting that the thread was pinned.');
    }

    /** @test */
    public function administrators_can_unpin_threads()
    {
        $thread = factory(Thread::class)->create(['pinned' => true]);

        $this->actingAs($this->admin)
            ->delete(route('pinned-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->pinned, 'Failed asserting that the thread was unpinned.');
    }

    /** @test */
    public function pinned_threads_are_listed_first()
    {
        $this->be($this->admin);

        factory(Thread::class)->create(['created_at' => now()->subDays(1)]);
        factory(Thread::class)->create(['created_at' => now()->subDays(2)]);
        $threadToPin = factory(Thread::class)->create(['created_at' => now()->subDays(3)]);

        $ids = Thread::latest()->pluck('id');

        $dataWithNoPinnedThreads = $this->getJson(route('threads.index'))->json('data');
        $this->assertEquals(
            $ids->toArray(),
            array_column($dataWithNoPinnedThreads, 'id')
        );

        $this->post(route('pinned-threads.store', $threadToPin));

        $dataWithPinnedThread = $this->getJson(route('threads.index'))->json('data');
        $this->assertEquals(
            [0 => $ids[2], 1 => $ids[0], 2 => $ids[1]],
            array_column($dataWithPinnedThread, 'id')
        );
    }
}
