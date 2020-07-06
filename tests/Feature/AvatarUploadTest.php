<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
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
    public function only_members_can_add_images()
    {
        $this->postJson(route('api.user.images.store', [$this->user, 'image', 'images']))
            ->assertUnauthorized();
    }

    /** @test */
    public function a_valid_image_must_be_provided()
    {
        $this->be($this->user);

        $this->postJson(route('api.user.images.store', [$this->user, 'image', 'images']), ['image' => 'not-an-image'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->be($this->user);

        Storage::fake('s3');
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->postJson(route('api.user.images.store', [$this->user, 'avatar', 'avatars']), [
            'avatar' => $avatar
        ]);

        $this->assertEquals($response->getOriginalContent(), Auth::user()->fresh()->avatar_path);
        Storage::disk('s3')->assertExists('avatars/' . $avatar->hashName());
    }

    /** @test */
    public function a_user_may_add_a_banner_to_their_profile()
    {
        $this->be($this->user);

        Storage::fake('s3');
        $banner = UploadedFile::fake()->image('banner.jpg');
        $response = $this->postJson(route('api.user.images.store', [$this->user, 'banner', 'banners']), [
            'banner' => $banner
        ]);

        $this->assertEquals($response->getOriginalContent(), Auth::user()->fresh()->banner_path);
        Storage::disk('s3')->assertExists('banners/' . $banner->hashName());
    }
}
