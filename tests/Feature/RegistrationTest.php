<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Event::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'username' => 'john',
            'email' => 'johndoe@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ]);

        Event::assertDispatched(Registered::class);
    }
}
