@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">
                <div class="flex flex-col break-words bg-card border border-2 rounded shadow-md">

                    <div class="font-semibold text-accent text-xl text-center py-3 px-6 mt-1 border-b-2 border-accent-light mx-6">
                        {{ __('Login') }}
                    </div>

                    <form class="w-full p-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">
                            <label for="email" class="block text-muted text-sm font-bold mb-2">
                                {{ __('E-Mail Address') }}:
                            </label>

                            <input id="email" type="email" class="bg-card form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <label for="password" class="block text-muted text-sm font-bold mb-2">
                                {{ __('Password') }}:
                            </label>

                            <input id="password" type="password" class="bg-card form-input w-full @error('password') border-red-500 @enderror" name="password" required>

                            @error('password')
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex mb-4">
                            <label class="inline-flex items-center text-sm text-muted" for="remember">
                                <input type="checkbox" name="remember" id="remember" class="form-checkbox bg-card" {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2">{{ __('Remember Me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center">
                                <button type="submit" class="button w-full mr-2">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="button-sm-no-bg" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>


                        @if (Route::has('register'))
                            <p class="w-full text-xs text-center text-muted mt-8 -mb-4">
                                {{ __("Don't have an account?") }}
                                <a class="text-accent no-underline" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </p>
                        @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
