<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Support\Facades\Config;
use Sti3bas\ScoutArray\Facades\Search;
use Tests\TestCase;

class SearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('scout.driver', 'array');
    }

    /** @test */
    public function a_user_can_search_threads()
    {
        $search = 'foobar';
        $threadThatShouldBeFound = factory(Thread::class)->create(['body' => "We are looking for {$search}"]);
        $threadThatShouldNotBeFound = factory(Thread::class)->create();

        Search::fakeRecord($threadThatShouldBeFound, $threadThatShouldBeFound->toSearchableArray());
        $results = $this->getJson("/threads/search?q={$search}")->json()['data'];

        $this->assertCount(1, $results);
        $this->assertEquals($threadThatShouldBeFound->body, $results[0]['body']);
        $this->assertNotEquals($threadThatShouldNotBeFound->body, $results[0]['body']);

        $this->get(route('threads.search'))
            ->assertOk();
    }
}
