<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = factory(Thread::class)->create();
        $thread->user->subscribeTo($thread);

        $this->assertCount(0, $thread->user->notifications);
        $thread->addReply(['body' => 'test reply'], $thread->user);
        $this->assertCount(0, $thread->user->fresh()->notifications);

        $user = factory(User::class)->create();
        $thread->addReply(['body' => 'test reply'], $user);
        $this->assertCount(1, $thread->user->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_clear_notifications()
    {
        $thread = factory(Thread::class)->create();
        $thread->user->subscribeTo($thread);

        $user = factory(User::class)->create();
        $thread->addReply(['body' => 'test reply'], $user);

        $this->assertCount(1, $thread->user->fresh()->unreadNotifications);
        $this->actingAs($thread->user)->delete(route('notifications.destroy', [$thread->user, $thread->user->unreadNotifications->first()]));
        $this->assertCount(0, $thread->user->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_fetch_all_unread_notifications()
    {
        $thread = factory(Thread::class)->create();
        $thread->user->subscribeTo($thread);

        $user = factory(User::class)->create();
        $thread->addReply(['body' => 'test reply'], $user);

        $response = $this->actingAs($thread->user)->getJson(route('notifications.index', $thread->user))->json();
        $this->assertCount(1, $response);
    }
}
