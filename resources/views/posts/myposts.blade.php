@extends('layouts.noa-layout')

@section('title', 'Listado de Mis Posts - Noa')

@section('content')
    @if($posts->isEmpty())
        <h1 class="text-4xl font-bold mb-6 text-center">No has publicado ningun post.</h1>
    @else
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Listado de mis noticias</h1>
        @endif

        @auth
            <div class="flex items-center justify-center">
                <a
                    href="{{ route('posts.create') }}"
                    class="group rounded-full bg-sky-600 p-2 text-sky-100 shadow-lg duration-300 hover:bg-sky-700 active:bg-sky-800"
                >
                    <svg
                        class="h-6 w-6 duration-300 group-hover:rotate-12"
                        data-slot="icon"
                        fill="none"
                        stroke-width="1.5"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        ></path>
                    </svg>
                </a>
            </div>
        @endauth

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h2>
                        @if($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-32 h-32 rounded-lg shadow-md mb-4">
                        @endif
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post->category}}</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post->excerpt }}</p>
                        <a href="{{ route('posts.show', $post) }}"
                           class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                            Leer más
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
