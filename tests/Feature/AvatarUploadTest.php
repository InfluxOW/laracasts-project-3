<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function only_members_can_add_avatars()
    {
        $this->postJson(route('api.avatars.store', $this->user))
            ->assertUnauthorized();
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->be($this->user);

        $this->postJson(route('api.avatars.store', $this->user), ['avatar' => 'not-an-image'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->be($this->user);

        Storage::fake('s3');
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson(route('api.avatars.store', $this->user), [
            'avatar' => $avatar
        ]);

        $this->assertEquals($response->getOriginalContent(), auth()->user()->avatar_path);
        Storage::disk('s3')->assertExists('avatars/' . $avatar->hashName());
    }
}
