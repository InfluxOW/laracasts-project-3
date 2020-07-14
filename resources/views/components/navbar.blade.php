<nav class="w-full {{ $navStyles ?? '' }}">
    <div
        class="{{ $background ?? '' }} container py-1 px-4 mx-auto flex flex-wrap {{ $dark == 'true' ? 'text-gray-800' : 'text-white' }}">
        <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
            <div
                class="text-md font-bold leading-relaxed inline-block py-2 whitespace-no-wrap uppercase cursor-pointer {{ $dark == 'true' ? 'text-black' : 'text-white' }}">
                Forum
            </div>
        </div>

        <div class="lg:flex lg:flex-grow items-center mr-auto">

            <!-- Left Navbar Side -->
            <ul class="flex flex-col lg:flex-row list-none">
                <li>
                    <dropdown
                        button_classes="{{ $dropdownButtonClass }} w-full"
                        button_title="Threads"
                    >
                        <template v-slot:items>
                            <a href="{{ route('threads.index') }}"
                               class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                All Threads
                            </a>

                            @auth
                                <a href="{{ route('threads.index', ['filter[user.username]' => Auth::user()->username]) }}"
                                   class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                    My Threads
                                </a>

                                <a href="{{ route('threads.index', ['filter[favorited_by_user]' => Auth::user()->username]) }}"
                                   class="text-sm py-2 px-4 font-normal block w-full break-words bg-transparent text-gray-800 hover:bg-gray-300">
                                    Favorited Threads
                                </a>

                                <a href="{{ route('threads.create') }}"
                                   class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                    New Thread
                                </a>
                            @endauth
                        </template>
                    </dropdown>
                </li>

                <li>
                    <channels inline-template>
                        <dropdown
                            button_classes="{{ $dropdownButtonClass }} w-full"
                            button_title="Channels"
                        >
                            <template v-slot:items>
                                <div class="channel-list overflow-auto">
                                    <div class="mb-2">
                                        <input type="text"
                                               class="border border-gray-500 rounded-lg text-xs p-2 w-full"
                                               v-model="filter"
                                               placeholder="Filter Channels..."/>
                                    </div>
                                    <a :href="'/threads/' + channel.slug" v-for="channel in filteredChannels" v-text="channel.name"
                                       class="text-sm p-2 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-400">
                                    </a>
                                </div>
                            </template>
                        </dropdown>
                    </channels>
                </li>
            </ul>

            <!-- Right Navbar Side -->
            <ul class="flex flex-col lg:flex-row list-none lg:ml-auto items-center">

                @auth
                    <user-notifications></user-notifications>
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}">
                            <svg class="w-4 h-4 z-10 hover:opacity-75 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                <path class="text-gray-800 fill-current" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M46.999,27.708v-5.5l-6.546-1.07c-0.388-1.55-0.996-3.007-1.798-4.342l3.815-5.437L38.58,7.472l-5.368,3.859c-1.338-0.81-2.805-1.428-4.366-1.817L27.706,3h-5.5l-1.06,6.492c-1.562,0.383-3.037,0.993-4.379,1.799l-5.352-3.824l-3.889,3.887l3.765,5.384c-0.814,1.347-1.433,2.82-1.826,4.392l-6.464,1.076v5.5l6.457,1.145c0.39,1.568,1.009,3.041,1.826,4.391l-3.816,5.337l3.887,3.891l5.391-3.776c1.346,0.808,2.817,1.423,4.379,1.808L22.206,47h5.5l1.156-6.513c1.554-0.394,3.022-1.013,4.355-1.824l5.428,3.809l3.888-3.891l-3.875-5.38c0.802-1.335,1.411-2.794,1.795-4.344L46.999,27.708z"/>
                                <path class="stroke-2 text-white fill-current" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M25 18A7 7 0 1 0 25 32A7 7 0 1 0 25 18Z"/>
                            </svg>
                        </a>
                    @endif
                    <li>
                        <dropdown
                            button_classes="{{ $dropdownButtonClass }} w-full"
                            button_title="{{ Auth::user()->name }}"
                        >
                            <template v-slot:items>
                                <a href="{{ route('profiles.show', Auth::user()) }}"
                                   class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                    Profile
                                </a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                   class="text-sm py-2 px-4 font-normal block w-full whitespace-no-wrap bg-transparent text-gray-800 hover:bg-gray-300">
                                    Logout
                                </a>
                                {!! Form::open(['url' => route('logout'), 'id' => 'logout-form', 'class' => 'invisible']) !!}
                                {!! Form::close() !!}
                            </template>
                        </dropdown>
                    </li>
                @else
                    <a class="px-4 py-2 flex items-center text-xs uppercase leading-snug hover:opacity-75"
                       href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="px-4 py-2 flex items-center text-xs uppercase leading-snug hover:opacity-75"
                       href="{{ route('register') }}">{{ __('Register') }}</a>
                @endauth
            </ul>
        </div>
    </div>
</nav>
