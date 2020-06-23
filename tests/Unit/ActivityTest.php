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
            'subject_type' => 'thread',
            'log_name' => 'threads_log'
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
            'subject_type' => 'thread',
            'log_name' => 'threads_log'
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
            'subject_type' => 'user',
            'log_name' => 'users_log'
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
            'subject_type' => 'user',
            'log_name' => 'users_log'
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
            'subject_type' => 'user',
            'log_name' => 'users_log'
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
            'subject_type' => 'reply',
            'log_name' => 'replies_log'
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
            'subject_type' => 'reply',
            'log_name' => 'replies_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_favorited()
    {
        activity()->disableLogging();
        $reply = factory(Reply::class)->create();
        activity()->enableLogging();

        $reply->user->favorite($reply);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply',
            'log_name' => 'favorites_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_unfavorited()
    {
        activity()->disableLogging();
        $reply = factory(Reply::class)->create();
        $reply->user->favorite($reply);
        activity()->enableLogging();

        $reply->user->unfavorite($reply);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply',
            'log_name' => 'favorites_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'reply')->get());
        $this->assertEquals(Activity::where('subject_type', 'reply')->first()->subject, Reply::find($reply->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_favorited()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        activity()->enableLogging();

        $thread->user->favorite($thread);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread',
            'log_name' => 'favorites_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_unfavorited()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        $thread->user->favorite($thread);
        activity()->enableLogging();

        $thread->user->unfavorite($thread);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread',
            'log_name' => 'favorites_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_subscribed_to()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        activity()->enableLogging();

        $thread->user->subscribeTo($thread);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread',
            'log_name' => 'subscribes_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_unsubscribed_from()
    {
        activity()->disableLogging();
        $thread = factory(Thread::class)->create();
        $thread->user->subscribeTo($thread);
        activity()->enableLogging();

        $thread->user->unsubscribeFrom($thread);

        $this->assertDatabaseHas('activity_log', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread',
            'log_name' => 'subscribes_log'
        ]);
        $this->assertCount(1, Activity::where('subject_type', 'thread')->get());
        $this->assertEquals(Activity::where('subject_type', 'thread')->first()->subject, Thread::find($thread->id));
    }
}
