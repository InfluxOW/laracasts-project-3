<div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-2 border-white bg-opacity-75">
    <div class="rounded-t mb-0 px-6 py-6">
        <div class="text-center mb-3">
            <h6 class="text-gray-800 text-sm font-bold">
                Sign in with
            </h6>
        </div>
        <div class="btn-wrapper text-center">
            <a
                class="bg-white active:bg-gray-100 text-gray-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-lg inline-flex items-center font-bold text-xs"
                href="{{ route('socialite.login', 'github') }}"
                style="transition: all 0.15s ease 0s;"
            >
                <img
                    alt="..."
                    class="w-5 mr-1"
                    src="{{ asset('/storage/icons/github.svg') }}"
                />
                Github
            </a>
            <button
                class="bg-white active:bg-gray-100 text-gray-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 uppercase shadow hover:shadow-lg inline-flex items-center font-bold text-xs"
                type="button"
                style="transition: all 0.15s ease 0s;"
            >
                <img
                    alt="..."
                    class="w-5 mr-1"
                    src="{{ asset('/storage/icons/google.svg') }}"
                />Google
            </button>
        </div>
        <hr class="mt-6 border-b-1 border-gray-400"/>
    </div>
    <div class="flex-auto px-4 lg:px-10 pb-6">
        <div class="text-gray-800 text-center mb-3 font-bold text-xs">
            Or sign in with credentials
        </div>
        {!! Form::open(['url' => route('login')]) !!}
        @honeypot
        <div class="relative w-full mb-3">
            <label
                class="block uppercase text-gray-700 text-xs font-bold mb-2"
            >Email</label
            ><input
                type="email"
                name="email"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Email..."
                value="{{ old('email') }}"
                style="transition: all 0.15s ease 0s;"
            />
        </div>
        <div class="relative w-full mb-3">
            <label
                class="block uppercase text-gray-700 text-xs font-bold mb-2"
            >Password</label
            ><input
                type="password"
                name="password"
                class="px-3 py-3 placeholder-gray-600 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                placeholder="Password..."
                style="transition: all 0.15s ease 0s;"
            />
        </div>
        <div>
            <label class="inline-flex items-center cursor-pointer">
                <input id="customCheckLogin" type="checkbox" class="form-checkbox text-gray-800 ml-1 w-5 h-5"
                       style="transition: all 0.15s ease 0s;"/>
                <span class="ml-2 text-sm font-semibold text-gray-700">Remember me</span>
            </label>
        </div>
        <div class="text-center mt-6">
            <button
                class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                type="submit"
                style="transition: all 0.15s ease 0s;"
            >
                Sign In
            </button>
        </div>
        {!! Form::close() !!}

        <div class="flex flex-wrap">
            <div class="w-1/2">
                <a href="{{ route('password.request') }}" class="text-gray-800 text-xs hover:text-gray-600">
                    Forgot password?
                </a
                >
            </div>
            <div class="w-1/2 text-right">
                <a href="{{ route('register') }}" class="text-gray-800 text-xs hover:text-gray-600">
                    Don't have an account?
                </a>
            </div>
        </div>
    </div>
</div>
