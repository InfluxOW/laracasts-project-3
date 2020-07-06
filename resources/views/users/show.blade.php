@extends('layouts.app')

@section('content')
    <profile inline-template>
        <main class="profile-page">
            <section class="relative block" style="height: 500px;">
                <div
                    class="absolute top-0 w-full h-full bg-center bg-cover"
                    style='background-image: url("{{ $user->getBanner() }}");'
                >
                </div>
            </section>
            <section class="relative pt-16">
                <div class="container mx-auto px-4">
                    <div v-if="! editing" class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                    <div class="relative">
                                        <img
                                            alt="..."
                                            src="{{ $user->getAvatar() }}"
                                            class="shadow-lg rounded-full h-auto align-middle border-none absolute -m-24 -ml-24 max-w-sm"
                                        />
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                                    <div class="py-6 px-3 mt-32 sm:mt-0">
                                        @can('update', $user)
                                            <button
                                                class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1"
                                                type="button"
                                                style="transition: all 0.15s ease 0s;"
                                                @click="editing = true"
                                            >
                                                Edit
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                    <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                        <div class="mr-4 p-3 text-center">
                                      <span class="text-xl font-bold block uppercase tracking-wide text-gray-700">
                                          <a href="{{ route('threads.index', ['filter[user.username]' => $user->username]) }}">
                                              {{ $user->threads_count }}
                                          </a>
                                      </span>
                                            <span class="text-sm text-gray-500">
                                            Threads
                                        </span>
                                        </div>
                                        <div class="mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-gray-700">
                                            {{ $user->replies_count }}
                                        </span>
                                            <span class="text-sm text-gray-500">
                                            Comments
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="text-center mt-12">
                                    <h3 class="text-4xl font-semibold mb-1 text-gray-800">
                                        {{ $user->name }}
                                    </h3>
                                    <div class="text-lg font-semibold mb-1 text-gray-600">
                                        {{ "@{$user->username}" }}
                                    </div>
                                    <div class="text-sm leading-normal mt-4 mb-2 text-gray-500 font-bold uppercase inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="mr-2 w-6 h-6">
                                            <path d="M468.329,358.972c-7.263-3.989-16.382-1.336-20.369,5.924c-3.989,7.261-1.337,16.381,5.924,20.369   C471.752,395.081,482,405.963,482,415.121c0,11.201-15.87,28.561-60.413,43.694C377.582,473.767,318.775,482,256,482   s-121.582-8.233-165.587-23.185C45.87,443.683,30,426.322,30,415.121c0-9.158,10.248-20.04,28.116-29.857   c7.261-3.988,9.913-13.108,5.924-20.369c-3.989-7.26-13.106-9.913-20.369-5.924C23.749,369.916,0,388.542,0,415.121   c0,20.374,14.012,49.422,80.762,72.1C127.794,503.2,190.028,512,256,512s128.206-8.8,175.238-24.779   c66.75-22.678,80.762-51.726,80.762-72.1C512,388.542,488.251,369.916,468.329,358.972z"/>
                                            <path d="M142.752,437.13c30.45,8.602,70.669,13.34,113.248,13.34s82.798-4.737,113.248-13.34   c37.253-10.523,56.142-25.757,56.142-45.275c0-19.519-18.889-34.751-56.142-45.274c-8.27-2.336-17.264-4.385-26.826-6.133   c-5.193,8.972-10.634,18.207-16.323,27.708c10.584,1.588,20.521,3.535,29.545,5.834c27.416,6.983,37.432,14.844,39.491,17.866   c-2.06,3.023-12.074,10.884-39.49,17.866c-25.949,6.609-59.335,10.379-94.498,10.716c-1.703,0.126-3.419,0.197-5.147,0.197   c-1.729,0-3.444-0.071-5.148-0.197c-35.163-0.337-68.549-4.106-94.498-10.716c-27.416-6.982-37.431-14.844-39.49-17.866   c2.059-3.022,12.075-10.883,39.491-17.866c9.024-2.298,18.961-4.246,29.546-5.834c-5.689-9.5-11.13-18.737-16.323-27.708   c-9.562,1.749-18.557,3.797-26.826,6.133c-37.253,10.523-56.142,25.756-56.142,45.274   C86.61,411.373,105.499,426.606,142.752,437.13z"/>
                                            <path d="M256,390.634c13.353,0,25.482-6.804,32.448-18.201c48.81-79.857,106.992-185.103,106.992-232.994   C395.44,62.552,332.888,0,256,0S116.56,62.552,116.56,139.439c0,47.891,58.183,153.137,106.992,232.994   C230.518,383.83,242.648,390.634,256,390.634z M199.953,129.865c0-30.903,25.143-56.045,56.047-56.045s56.047,25.142,56.047,56.045   c0,30.904-25.143,56.046-56.047,56.046S199.953,160.77,199.953,129.865z"/>
                                        </svg>
                                        {{ $user->location ?? 'Location...' }}
                                    </div>
                                    <br>
                                    <div class="mb-2 text-gray-700 inline-flex items-center">
                                        <svg viewBox="0 0 24 24" class="mr-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg"><path d="m15 6.5c-.552 0-1-.448-1-1v-1.5h-4v1.5c0 .552-.448 1-1 1s-1-.448-1-1v-1.5c0-1.103.897-2 2-2h4c1.103 0 2 .897 2 2v1.5c0 .552-.448 1-1 1z"/><path d="m12.71 15.38c-.18.07-.44.12-.71.12s-.53-.05-.77-.14l-11.23-3.74v7.63c0 1.52 1.23 2.75 2.75 2.75h18.5c1.52 0 2.75-1.23 2.75-2.75v-7.63z"/><path d="m24 7.75v2.29l-11.76 3.92c-.08.03-.16.04-.24.04s-.16-.01-.24-.04l-11.76-3.92v-2.29c0-1.52 1.23-2.75 2.75-2.75h18.5c1.52 0 2.75 1.23 2.75 2.75z"/></svg>
                                        {{ $user->job ?? 'Job...' }}
                                    </div>
                                    <br>
                                    <div class="mb-2 text-gray-700 inline-flex items-center">
                                        <svg viewBox="-3 0 456 456.392" class="mr-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg"><path d="m14.277344 128.390625 24.320312 14.304687c5.894532-5 13.125-8.171874 20.796875-9.128906l171.898438-21.117187c4.386719-.539063 8.378906 2.578125 8.917969 6.964843.539062 4.390626-2.578126 8.382813-6.96875 8.921876l-171.894532 21.121093c-2.585937.335938-5.101562 1.09375-7.441406 2.246094l178.289062 105.082031 217.921876-128.394531-217.921876-128.390625zm0 0"/><path d="m228.132812 272.96875-155.9375-91.863281v83.285156c0 22.023437 19.039063 43.433594 52.234376 58.738281 34.023437 14.589844 70.746093 21.835938 107.765624 21.261719 37.015626.578125 73.738282-6.667969 107.761719-21.261719 33.199219-15.304687 52.238281-36.714844 52.238281-58.738281v-83.285156l-155.933593 91.863281c-2.507813 1.476562-5.621094 1.476562-8.128907 0zm0 0"/><path d="m48.195312 440.390625-16-88-32 104zm0 0"/><path d="m56.195312 328.390625c-.015624-10.140625-6.429687-19.167969-16-22.527344v-132.589843c.023438-3.367188.757813-6.691407 2.160157-9.753907 2.304687-5.160156 6.355469-9.339843 11.441406-11.808593l-15.25-9.007813c-4.144531 3.515625-7.535156 7.839844-9.957031 12.703125-2.847656 5.527344-4.351563 11.648438-4.394532 17.867188v132.589843c-11.476562 4.089844-18.058593 16.136719-15.296874 28.003907 2.765624 11.867187 13.992187 19.769531 26.09375 18.367187 12.101562-1.398437 21.226562-11.660156 21.203124-23.84375zm0 0"/></svg>
                                        {{ $user->university ?? 'University...' }}
                                    </div>
                                </div>
                                <div class="mt-10 py-10 border-t border-gray-300 text-center">
                                    <div class="flex flex-wrap justify-center">
                                        <div class="w-full lg:w-9/12 px-4">
                                            <p class="mb-4 text-lg leading-relaxed text-gray-800">
                                                {{ $user->description ?? 'Description...' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (! empty($actions->items()))
                            <button @click="showUserActions()" class="button-dropdown-blue self-center mb-2">User Activity</button>
                            <x-users.actions :actions="$actions" :user="$user"/>
                        @endif
                    </div>

                    <div v-if="editing" class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                        {!! Form::open(['url' => route('profiles.update', $user), 'method' => 'PATCH', 'id' => 'user-form']) !!}
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                    <div class="relative">
                                        <file-uploader url="{{ route('api.user.images.store', [$user, 'avatar', 'avatars']) }}" inline-template>
                                            <file-pond
                                                name="avatar"
                                                :server="{
                                                      url: url,
                                                      process: {
                                                        headers: {
                                                          'X-CSRF-TOKEN': csrfToken
                                                        }
                                                      }
                                                    }"
                                                label-idle="Upload your avatar..."
                                                image-preview-height="200"
                                                image-crop-aspect-ratio="1:1"
                                                image-resize-target-width="200"
                                                image-resize-target-height="200"
                                                style-panel-layout="compact circle"
                                                style-button-remove-item-position="bottom center"
                                                style-button-process-item-position="bottom center"
                                                style-load-indicator-position="bottom center"
                                                style-progress-indicator-position="bottom center"
                                                max-files="1"
                                                max-file-size="1MB"
                                                accepted-file-types="image/png, image/jpeg, image/jpg, image/gif, image/svg"
                                                class="h-auto align-middle border-none absolute -m-24 -ml-24"
                                                style="width: 200px"
                                            >
                                            </file-pond>
                                        </file-uploader>
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                                    <div class="py-6 mt-32 sm:mt-0">
                                        <button
                                            class="bg-blue-500 active:bg-blue-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1"
                                            type="submit"
                                            style="transition: all 0.15s ease 0s;"
                                            onclick="event.preventDefault();document.getElementById('user-form').submit();"
                                        >
                                            Save
                                        </button>
                                        <button
                                            class="bg-gray-500 active:bg-gray-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1"
                                            type="button"
                                            style="transition: all 0.15s ease 0s;"
                                            @click="editing = false"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                </div>
                            </div>
                            <div class="border border-gray-500 p-10 m-10 rounded-lg bg-gray-200">
                                <div class="text-center mb-2">
                                    <div class="mb-2">
                                        {!! Form::text('name', $user->name, ['placeholder' => 'Name...', 'class' => 'text-4xl font-semibold leading-normal text-gray-800 text-center p-1 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! Form::text('username', $user->username, ['placeholder' => 'Username...', 'class' => 'text-lg font-semibold leading-normal text-gray-600 text-center p-1 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! Form::text('location', $user->location, ['placeholder' => 'Location...', 'class' => 'text-center text-gray-700 p-1 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! Form::text('job', $user->job, ['placeholder' => 'Job...', 'class' => 'text-center text-gray-700 p-1 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                    </div>
                                    <div class="mb-2">
                                        {!! Form::text('university', $user->university, ['placeholder' => 'University...', 'class' => 'text-center text-gray-700 p-1 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="flex flex-wrap justify-center">
                                        <div class="w-full lg:w-9/12 px-4">
                                            {!! Form::textarea('description', $user->description, ['placeholder' => 'Description...', 'rows' => '3', 'class' => 'w-full text-lg leading-relaxed text-gray-800 p-4 m-1 rounded-lg border border-gray-500 focus:shadow-outline']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </main>
    </profile>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer background="bg-white bg-opacity-25" styles="py-6" dark="true"/>
@endsection
