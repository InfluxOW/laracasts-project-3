<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    private $socialite;
    private $provider;

    public function __construct(Socialite $socialite, Request $request)
    {
        $this->socialite = $socialite;
        $this->provider = $request->provider;
    }

    public function redirectToProvider()
    {
        return $this->socialite::driver($this->provider)->redirect();
    }

    public function handleProviderCallback()
    {
        $socialiteUser = $this->socialite::driver($this->provider)->user();
        $validator = $this->validator($this->getUserData($socialiteUser));
        if ($validator->fails()) {
            return redirect()->route('register');
        }

        $user = $this->findOrCreateSocialiteUser($validator->validated());
        Auth::login($user, true);

        flash('You are successfully signed in')->success();
        return redirect()->route('threads.index');
    }


    public function findOrCreateSocialiteUser($userdata)
    {
        return User::where(["{$this->provider}_id" => $userdata["{$this->provider}_id"]])->first() ?? User::create($userdata);
    }

    protected function validator($data)
    {
        return Validator::make(
            $data,
            [
                "{$this->provider}_id" => ['required', 'integer'],
                'name' => ['required', 'string', 'max:255', 'min:3'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'min:3', 'alpha_dash'],
                'avatar_path' => ['nullable', 'url'],
                'email_verified_at' => ['date'],
                'password' => ['required', 'string', 'min:8']
            ]
        );
    }

    protected function getUserData($user)
    {
        return [
            "{$this->provider}_id" => (int) $user->getId(),
            'name' => $user->getName(),
            'username' => $user->getNickname() ?? slugify($user->getName()),
            'email_verified_at' => now(),
            'password' => Hash::make(random_bytes(10)),
            'email' => $user->getEmail(),
            'avatar_path' => $user->getAvatar()
        ];
    }
}
