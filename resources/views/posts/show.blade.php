@extends('layouts.noa-layout')

@section('title', $post->title)

@section('content')
    <article class="mx-auto flex max-w-4xl flex-col">
        @auth
            @can('update', $post)
                <div class="flex items-center justify-center space-x-10">
                    <a class="rounded-full bg-sky-600 p-4 text-sky-100 shadow-lg hover:bg-sky-700 active:bg-sky-800"
                       href="{{ route('posts.edit', $post) }}">
                        <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"></path>
                        </svg>
                    </a>
                </div>
            @endcan
        @endauth

        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-32 h-32 rounded-lg shadow-md mb-4">

        <div class="flex-1 space-y-3 pt-4 md:text-center">
            <h2 class="text-2xl font-semibold leading-tight text-slate-800 dark:text-slate-200 md:text-4xl">
                {{ $post->title }}
            </h2>
        </div>

        <div class="prose prose-slate mx-auto mt-6 dark:prose-invert lg:prose-xl">
            <p>{{ $post->content }}</p>
            <p>Autor: {{ $post->user->name }}</p>
        </div>

        {{-- Formulario para agregar comentarios --}}
        @auth
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Agregar un comentario</h3>
                <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="content" rows="3" required
                              class="w-full p-2 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <button type="submit"
                            class="mt-2 px-4 py-2 bg-blue-300 text-black rounded-lg shadow hover:bg-blue-700 hover:text-white">
                        Comentar
                    </button>
                </form>
            </div>
        @endauth

        {{-- Lista de comentarios --}}
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Comentarios</h3>

                @if($post->comments->where('parent_id', null)->isEmpty())
                    <p class="mt-4 text-gray-500">No hay comentarios aún. Sé el primero en comentar.</p>
                @else
                    @foreach($post->comments->where('parent_id', null) as $comment)
                        @include('components.comment', ['comment' => $comment])
                    @endforeach
                @endif
            </div>

    </article>
@endsection



