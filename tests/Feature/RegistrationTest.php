<?php

namespace Tests\Feature;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
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
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $this->post(route('register'), [
            'name' => 'John',
            'username' => 'john',
            'email' => 'johndoe@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
            'g-recaptcha-response' => '1'
        ]);

        Event::assertDispatched(Registered::class);
    }
}
