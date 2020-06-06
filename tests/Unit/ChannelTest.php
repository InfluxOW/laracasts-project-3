<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    protected $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = factory(Channel::class)->create();
    }

    /** @test */
    public function it_consists_of_threads()
    {
        $thread = factory(Thread::class)->create(['channel_id' => $this->channel->id]);

        $this->assertInstanceOf(Collection::class, $this->channel->threads);
        $this->assertCount(1, $this->channel->threads);
        $this->assertTrue($this->channel->threads->contains($thread));
    }
}
