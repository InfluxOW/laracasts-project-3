<?php

namespace Tests;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function verifyCaptcha()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);
    }
}
