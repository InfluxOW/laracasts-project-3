<?php

namespace Tests\Feature;

use App\Events\UserEarnedReputation;
use App\Reply;
use App\Reputation;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ReputationTest extends TestCase
{
    /** @test */
    public function a_user_earns_points_when_he_creates_thread()
    {
        $thread = factory(Thread::class)->create();
        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED, $thread->user->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_he_replies_to_thread()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $this->assertEquals(Reputation::REPLY_POSTED, $reply->user->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_his_reply_is_marked_as_best()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $reply->markAsBest();
        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::BEST_REPLY_AWARDED, $reply->user->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_his_reply_is_favorited()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $user->favorite($reply);

        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED, $reply->fresh()->user->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_he_deletes_thread()
    {
        $thread = factory(Thread::class)->create();
        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED, $thread->user->reputation);
        $thread->delete();
        $this->assertEquals(0, $thread->user->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_he_deletes_reply()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $this->assertEquals(Reputation::REPLY_POSTED, $reply->user->reputation);

        $reply->delete();
        $this->assertEquals(0, $reply->user->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_thread_owners_marks_another_reply_as_best()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $reply->markAsBest();
        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::BEST_REPLY_AWARDED, $reply->user->reputation);

        $anotherReply = factory(Reply::class)->create(['thread_id' => $thread->id]);
        $anotherReply->markAsBest();
        $this->assertEquals(Reputation::REPLY_POSTED, $reply->fresh()->user->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_his_reply_is_unfavorited()
    {
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => $user->id]);
        $user->favorite($reply);
        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED, $reply->fresh()->user->reputation);

        $user->unfavorite($reply);
        $this->assertEquals(Reputation::REPLY_POSTED, $reply->user->reputation);
    }

    /** @test */
    public function an_announcement_is_made_when_reputation_is_earned()
    {
        Event::fake();
        Event::assertNotDispatched(UserEarnedReputation::class);

        Reputation::award($user = factory(User::class)->create(), $points = 10);

        Event::assertDispatched(UserEarnedReputation::class, function ($event) use ($user, $points) {
            return $user->is($event->user) && $event->points === $points && $event->totalPoints === $points;
        });
    }
}
