@extends('layouts.noa-layout')

@section('title', 'Listado de Posts')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Listado de Noticias</h1>

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
