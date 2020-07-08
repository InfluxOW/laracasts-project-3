@extends('layouts.app')

@section('content')
<thread inline-template :thread="{{ $thread }}" v-cloak>
    <div>
        <div v-if="! editing">
            <!--Title-->
            <div class="text-center pt-4 md:pt-8 bg-white bg-opacity-25 container max-w-6xl">
                <p class="text-sm md:text-base text-blue-400 font-bold">{{ $thread->created_at->format('M d, Y') }}
                    <span class="text-gray-900 mx-2">/</span>
                    <a href="{{ route('profiles.show', $thread->user) }}" class="hover:text-blue-300">
                        {{ $thread->user->name }}
                    </a>
                </p>
                <h1 class="font-bold break-normal text-3xl md:text-5xl" v-text="title"></h1>
            </div>

            <div class="container max-w-6xl flex justify-between mt-2">
                <div class="inline-flex">
                    @auth
                        @if (Auth::user()->is_admin)
                            <button class="button-dropdown-red mr-2" @click="closeThread"
                                    v-show="{{ ! $thread->closed }}">Close Thread
                            </button>
                        @endif
                        <div class="mr-2">
                            <subscribe-button
                                subscribed="{{ Auth::user()->isSubscribedTo($thread) }}"
                                endpoint="{{ route('subscriptions.store', [$thread->getMorphClass(), $thread->getKey()]) }}">
                            </subscribe-button>
                        </div>
                    @endauth
                </div>
                <div class="inline-flex">
                    @can('update', $thread)
                        <button class="button-dropdown-blue mr-2" @click="editing = true">Edit</button>
                    @endcan

                    @can('delete', $thread)
                        <a
                            href="{{ route('threads.destroy', $thread) }}"
                            data-confirm="Are you sure?"
                            data-method="delete"
                            rel="nofollow"
                            class="button-dropdown-red">Delete</a>
                    @endcan
                </div>
            </div>
            <!--image-->
            <div class="container w-full max-w-6xl mx-auto bg-cover mt-2 mb-4 rounded"
                 :style="{ backgroundImage: `url('${form.image}')` }"
                 style="height: 75vh;"></div>

            <!--Container-->
            <div class="container max-w-5xl mx-auto -mt-32 mb-4">
                <div class="mx-0 sm:mx-6">
                    <div class="bg-white rounded w-full p-4 md:p-8 text-base md:text-xltext-gray-800 leading-normal"
                        style="font-family:Georgia,serif;">

                        <!--Post Content-->
                        <p v-html="body" class="wysiwyg"></p>
                    </div>
                </div>
            </div>

            @if ($thread->recomendations->count() > 0)
                <div class="bg-blue-200 rounded-lg bg-opacity-25">
                    <h2 class="text-2xl text-center py-2 font-bold tracking-wider text-gray-800">You may find it
                        interesting...</h2>
                    <div class="container px-12">
                        <div class="flex flex-wrap -mx-2">
                            @foreach ($thread->recomendations as $recomendation)
                                <x-threads.card :thread="$recomendation" classes="shadow-lg"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="container">
                <replies>
                    <template v-slot:honeypot>
                        @honeypot
                    </template>
                </replies>
            </div>
        </div>

        <div v-if="editing" class="pt-4 md:pt-8 bg-white container max-w-6xl border rounded-lg p-4 pb-2 mt-12">
            <div class="mb-2">
                <file-uploader url="{{ route('uploads.store', ['image', 'threads']) }}" inline-template>
                    <file-pond
                        ref="pond"
                        name="image"
                        :server="{
                          url: url,
                          process: {
                            headers: {
                              'X-CSRF-TOKEN': csrfToken
                            },

                            onload: (response) => { $parent.form.image = response.match('\\b(https?:\\/\\/\\S+(?:png|jpe?g|gif))\\b')[0] }
                          }
                        }"
                        label-idle="Upload your image..."
                        image-preview-height="300"
                        style-panel-layout="compact"
                        image-validate-size-min-width="720"
                        image-validate-size-max-width="1920"
                        image-validate-size-min-height="400"
                        image-validate-size-max-height="1080"
                        max-files="1"
                        max-file-size="2MB"
                        accepted-file-types="image/png, image/jpeg, image/jpg, image/gif, image/svg"
                    >
                    </file-pond>
                </file-uploader>

                <label for="title" class="text-default font-light text-xs opacity-75">Title</label>
                <input class="border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full" type="text"
                       v-model="form.title" placeholder="Title..."
                >

                <label for="body" class="text-default font-light text-xs opacity-75">Body</label>
                <wysiwyg name="body" :value="form.body" v-model="form.body" class="mt-2 mb-4"></wysiwyg>
            </div>
            <div class="inline-flex my-2 text-center justify-center w-full">
                <button
                    class="uppercase font-bold text-xs text-blue-600 outline-none focus:outline-none hover:opacity-75 mr-2"
                    @click="update"
                >
                    Update
                </button>
                <button
                    class="uppercase font-bold text-xs text-gray-600 outline-none focus:outline-none hover:opacity-75 mr-2"
                    @click="resetForm"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</thread>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer background="bg-white bg-opacity-25" styles="py-6" dark="true"/>
@endsection
