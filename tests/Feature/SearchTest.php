<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class SearchTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
        Config::set('scout.driver', 'algolia');
    }

    /** @test */
    public function a_user_can_search_threads()
    {
        $search = 'foobar';
        factory(Thread::class, 2)->create();
        factory(Thread::class, 2)->create(['body' => "We are looking for {$search}"]);

        do {
            sleep(0.25);
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while(empty($results));

        $this->assertCount(2, $results);

        Thread::all()->unsearchable();
    }
}
