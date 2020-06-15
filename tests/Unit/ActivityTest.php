<?php

namespace Tests\Unit;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Spatie\Activitylog\Models\Activity;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $thread = factory(Thread::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_updated()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        activity()->enableLogging();

        $thread->update(['body' => 'new body']);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_deleted()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        activity()->enableLogging();

        $thread->delete();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_user_is_created()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $user->id,
            'subject_type' => 'user'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'user')->get());
        $this->assertEquals(Activity::where('subject_type', 'user')->first()->subject, User::find($user->id));
    }

    /** @test */
    public function it_records_activity_when_a_user_is_updated()
    {
        activity()->disableLogging();
        $user = factory(User::class)->create();
        activity()->enableLogging();

        $user->update(['name' => 'new name']);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $user->id,
            'subject_type' => 'user'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'user')->get());
        $this->assertEquals(Activity::where('subject_type', 'user')->first()->subject, User::find($user->id));
    }

    /** @test */
    public function it_records_activity_when_a_user_is_deleted()
    {
        activity()->disableLogging();
        $user = factory(User::class)->create();
        activity()->enableLogging();

        $user->delete();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $user->id,
            'subject_type' => 'user'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'user')->get());
        $this->assertEquals(Activity::where('subject_type', 'user')->first()->subject, User::find($user->id));
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $reply = factory(Reply::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_updated()
    {
        activity()->disableLogging();
        $reply = factory(Reply::class)->create();
        activity()->enableLogging();

        $reply->update(['body' => 'new body']);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_deleted()
    {
        activity()->disableLogging();
        $reply = factory(Reply::class)->create();
        activity()->enableLogging();

        $reply->delete();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_channel_is_created()
    {
        $channel = factory(Channel::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $channel->id,
            'subject_type' => 'channel'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'channel')->get());
        $this->assertEquals(Activity::where('subject_type', 'channel')->first()->subject, Channel::find($channel->id));
    }

    /** @test */
    public function it_records_activity_when_a_channel_is_updated()
    {
        activity()->disableLogging();
        $channel = factory(Channel::class)->create();
        activity()->enableLogging();

        $channel->update(['name' => 'new name']);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $channel->id,
            'subject_type' => 'channel'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'channel')->get());
        $this->assertEquals(Activity::where('subject_type', 'channel')->first()->subject, Channel::find($channel->id));
    }

    /** @test */
    public function it_records_activity_when_a_channel_is_deleted()
    {
        activity()->disableLogging();
        $channel = factory(Channel::class)->create();
        activity()->enableLogging();

        $channel->delete();

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $channel->id,
            'subject_type' => 'channel'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'channel')->get());
        $this->assertEquals(Activity::where('subject_type', 'channel')->first()->subject, Channel::find($channel->id));
    }
}
