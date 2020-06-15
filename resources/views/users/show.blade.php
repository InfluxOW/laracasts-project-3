@extends('layouts.app')

@section('content')
    <main class="profile-page">
        <section class="relative block" style="height: 500px;">
            <div
                class="absolute top-0 w-full h-full bg-center bg-cover"
                style='background-image: url("{{ $user->getBanner() }}");'
            >
            </div>
        </section>
        <section class="relative py-16">
            <div class="container mx-auto px-4">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64"
                >
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div
                                class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center"
                            >
                                <div class="relative">
                                    <img
                                        alt="..."
                                        src="{{ $user->getAvatar() }}"
                                        class="shadow-lg rounded-full h-auto align-middle border-none absolute -m-20 -ml-20"
                                        style="max-width: 150px;"
                                    />
                                </div>
                            </div>
                            <div
                                class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center"
                            >
                                <div class="py-6 px-3 mt-32 sm:mt-0">
                                    <button
                                        class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1"
                                        type="button"
                                        style="transition: all 0.15s ease 0s;"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="mr-4 p-3 text-center">
                                      <span
                                          class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                                      ><a href="{{ route('threads.index', ['filter[user.username]' => $user->username]) }}">{{ $user->threads_count }}</a></span
                                      ><span class="text-sm text-gray-500">Threads</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                      <span
                                          class="text-xl font-bold block uppercase tracking-wide text-gray-700"
                                      >{{ $user->replies_count }}</span
                                      ><span class="text-sm text-gray-500">Comments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-12">
                            <h3
                                class="text-4xl font-semibold leading-normal mb-2 text-gray-800 mb-2"
                            >
                                {{ $user->name }}
                            </h3>
                            <div
                                class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase"
                            >
                                <i
                                    class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"
                                ></i>
                                {{ $user->location ?? 'Los Angeles, California' }}
                            </div>
                            <div class="mb-2 text-gray-700 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i
                                >{{ $user->work ?? 'Solution Manager - Creative Tim Officer' }}
                            </div>
                            <div class="mb-2 text-gray-700">
                                <i class="fas fa-university mr-2 text-lg text-gray-500"></i
                                >{{ $user->university ?? 'University of Computer Science' }}
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-gray-300 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p class="mb-4 text-lg leading-relaxed text-gray-800">
                                        {{ $user->desctiption ?? 'An artist of considerable range, Jenna the name taken by
                                        Melbourne-raised, Brooklyn-based Nick Murphy writes,
                                        performs and records all of his own music, giving it a
                                        warm, intimate feel with a solid groove structure. An
                                        artist of considerable range.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('navbar')
    <x-navbar dark="true" background="bg-white bg-opacity-25" dropdownButtonClass="button-dropdown-dark"/>
@endsection

@section('footer')
    <x-footer background="bg-white bg-opacity-25" styles="py-6" dark="true"/>
@endsection
