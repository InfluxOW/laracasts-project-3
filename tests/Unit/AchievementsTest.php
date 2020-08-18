<?php

namespace Tests\Unit;

use App\Achievement;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    /** @test */
    public function it_has_a_name()
    {
        $achievement = factory(Achievement::class)->create(['name' => $name = 'Test Achievement']);
        $this->assertEquals($name, $achievement->name);
    }

    /** @test */
    public function it_has_a_description()
    {
        $achievement = factory(Achievement::class)->create(['description' => $description = 'Test Achievement']);
        $this->assertEquals($description, $achievement->description);
    }

    /** @test */
    public function it_has_an_icon()
    {
        $achievement = factory(Achievement::class)->create(['icon' => $icon = 'icon.svg']);
        $this->assertEquals($icon, $achievement->icon);
    }
}
