<div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-2 border-white bg-opacity-75">
    <div class="flex-auto px-4 lg:px-10 py-6">
        <div class="text-gray-800 text-center mb-6 font-bold text-sm">
            Create new account
        </div>
        {!! Form::open(['url' => route('register')]) !!}
        @honeypot
        <div class="relative w-full mb-3">
            <label class="block uppercase text-gray-700 text-xs font-bold mb-2">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white border-2 border-transparent @error('name') border-red-500 @enderror rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Name..."
                value="{{ old('name') }}"
                autocomplete="name"
                style="transition: all 0.15s ease 0s;"
            />

            <x-error name="name" classes="mt-2"/>

        </div>

        <div class="relative w-full mb-3">
            <label class="block uppercase text-gray-700 text-xs font-bold mb-2">
                Username
            </label>

            <input
                type="text"
                name="username"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white border-2 border-transparent @error('username') border-red-500 @enderror rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Username..."
                value="{{ old('username') }}"
                autocomplete="username"
                style="transition: all 0.15s ease 0s;"
            />

            <x-error name="username" classes="mt-2"/>

        </div>

        <div class="relative w-full mb-3">
            <label class="block uppercase text-gray-700 text-xs font-bold mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white border-2 border-transparent @error('email') border-red-500 @enderror rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Email..."
                value="{{ old('email') }}"
                autocomplete="email"
                style="transition: all 0.15s ease 0s;"
            />

            <x-error name="email" classes="mt-2"/>

        </div>

        <div class="relative w-full mb-3">
            <label class="block uppercase text-gray-700 text-xs font-bold mb-2">
                Password
            </label>
            <input
                type="password"
                name="password"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white border-2 border-transparent @error('password') border-red-500 @enderror rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Password..."
                autocomplete="new-password"
                style="transition: all 0.15s ease 0s;"
            />

            <x-error name="password" classes="mt-2"/>

        </div>

        <div class="relative w-full mb-3">
            <label class="block uppercase text-gray-700 text-xs font-bold mb-2">
                Password Confirmation
            </label>
            <input
                type="password"
                name="password_confirmation"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Password confimation..."
                autocomplete="new-password"
                style="transition: all 0.15s ease 0s;"
            />
        </div>

        <div class="text-center mt-6">
            <button
                class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                type="submit"
                style="transition: all 0.15s ease 0s;"
            >
                Register
            </button>
        </div>
        {!! Form::close() !!}

        <div class="flex flex-wrap">
            <div class="w-1/2">
                <a href="{{ route('password.request') }}" class="text-gray-800 text-xs hover:text-gray-600">
                    Forgot password?
                </a>
            </div>
            <div class="w-1/2 text-right">
                <a href="{{ route('login') }}" class="text-gray-800 text-xs hover:text-gray-600">
                    Already have an account?
                </a>
            </div>
        </div>
    </div>
</div>
