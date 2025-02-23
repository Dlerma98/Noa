@extends('layouts.noa-layout')

@section('title', $post->title)

@if(session('status'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 mx-auto w-1/2 text-center rounded-lg shadow-md">
        <p class="font-semibold">{{ session('status') }}</p>
    </div>
@endif

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
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-full bg-red-600 p-4 text-red-100 shadow-lg hover:bg-red-700 active:bg-red-800">
                        <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                        </svg>
                    </button>
                </form>
                </div>
            @endcan
            @endauth
        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-32 h-32 rounded-lg shadow-md mb-4">

            <div class="flex items-center justify-center space-x-10">
                <a class="rounded-full bg-green-600 p-4 text-white-100 shadow-lg hover:bg-green-700 active:bg-green-800"
                   href="{{ route('posts.pdf', $post) }}">
                    <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            </div>

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
            {{-- Formulario para agregar comentarios --}}
            @auth
                <div class="mt-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Agregar un comentario</h3>
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="content" rows="2" required
                                  class="w-full p-2 text-sm border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <button type="submit"
                                class="mt-2 px-3 py-1 bg-blue-300 text-black text-xs rounded-lg shadow hover:bg-blue-700 hover:text-white">
                            Comentar
                        </button>
                    </form>
                </div>
            @endauth

            {{-- Lista de comentarios --}}
            <div class="mt-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Comentarios</h3>

                @if($post->comments->where('parent_id', null)->isEmpty())
                    <p class="mt-3 text-sm text-gray-500">No hay comentarios aún. Sé el primero en comentar.</p>
                @else
                    <div class="space-y-3">
                        @foreach($post->comments->where('parent_id', null) as $comment)
                            <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded-lg shadow-md max-w-lg">
                                @include('components.comment', ['comment' => $comment])
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

    </article>
@endsection



