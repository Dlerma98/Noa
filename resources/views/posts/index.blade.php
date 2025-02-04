@extends('layouts.noa-layout')

@section('title', 'Listado de Posts')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Listado de Noticias</h1>

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

        <div>
            @foreach($posts as $post)
                <div class="mt-5 bg-red-600 rounded p-4">
                    <h2 class="text-2xl font-semibold">{{ $post->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-500 font-medium hover:underline">Leer más</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

