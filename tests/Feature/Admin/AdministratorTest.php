<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;

class AdministratorTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();

        $this->admin = factory('App\User')->state('admin')->create();
    }

    /** @test */
    public function an_administrator_can_access_the_administration_section()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    /** @test */
    public function a_non_administrator_cannot_access_the_administration_section()
    {
        $regularUser = factory(User::class)->create();

        $this->actingAs($regularUser)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
