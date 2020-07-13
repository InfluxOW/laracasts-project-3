<?php

namespace Tests\Feature\Admin;

use App\Channel;
use App\User;
use Tests\TestCase;

class ChannelAdministrationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory('App\User')->state('admin')->create();
    }

    /** @test */
    public function an_administrator_can_access_the_channel_administration_section()
    {
        $this->actingAs($this->admin)
             ->get(route('admin.channels.index'))
             ->assertOk();
    }

    /** @test */
    public function non_administrators_cannot_access_the_channel_administration_section()
    {
        $regularUser = factory(User::class)->create();

        $this->actingAs($regularUser)
             ->get(route('admin.channels.index'))
             ->assertForbidden();

        $this->actingAs($regularUser)
             ->get(route('admin.channels.create'))
             ->assertForbidden();
    }

    /** @test */
    public function an_administrator_can_create_a_channel()
    {
        $this->be($this->admin);
        $this->get(route('admin.channels.create'))
            ->assertOk();

        $attributes = ['name' => 'Test', 'description' => 'Test'];
        $this->post(route('admin.channels.store'), $attributes)
            ->assertRedirect();
        $this->assertDatabaseHas('channels', $attributes);
    }

    /** @test */
    public function an_administrator_can_update_a_channel()
    {
        $channel = factory(Channel::class)->create();
        $attributes = ['name' => 'Test', 'description' => 'Test'];
        $this->actingAs($this->admin)
            ->patch(route('admin.channels.update', $channel), $attributes)
            ->assertRedirect();
        $this->assertDatabaseHas('channels', $attributes);
    }

    /** @test */
    public function an_administrator_can_delete_a_channel()
    {
        $channel = factory(Channel::class)->create();
        $this->actingAs($this->admin)
            ->delete(route('admin.channels.destroy', $channel))
            ->assertRedirect();
        $this->assertDatabaseMissing('channels', $channel->toArray());
    }

    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->actingAs($this->admin)
            ->post(route('admin.channels.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }
}
