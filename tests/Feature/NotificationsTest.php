<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
        $this->thread->user->subscribeTo($this->thread);
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->assertCount(0, $this->thread->user->notifications);
        $this->thread->addReply(['body' => 'test reply'], $this->thread->user);
        $this->assertCount(0, $this->thread->user->fresh()->notifications);

        $this->thread->addReply(['body' => 'test reply'], $this->user);
        $this->assertCount(1, $this->thread->user->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_clear_notifications()
    {
        $this->thread->addReply(['body' => 'test reply'], $this->user);

        $this->assertCount(1, $this->thread->user->fresh()->unreadNotifications);
        $this->actingAs($this->thread->user)->delete(route('notifications.destroy', [$this->thread->user, $this->thread->user->unreadNotifications->first()]));
        $this->assertCount(0, $this->thread->user->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_fetch_all_unread_notifications()
    {
        $this->thread->addReply(['body' => 'test reply'], $this->user);

        $response = $this->actingAs($this->thread->user)->getJson(route('notifications.index', $this->thread->user))->json();
        $this->assertCount(1, $response);
    }
}
