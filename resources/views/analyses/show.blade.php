@extends('layouts.noa-layout')

@section('title', $analysis->title)

@if(session('status'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 mx-auto w-1/2 text-center rounded-lg shadow-md">
        <p class="font-semibold">{{ session('status') }}</p>
    </div>
@endif

@section('content')

    <article class="mx-auto flex max-w-4xl flex-col">
        @auth
            @can('update', $analysis)
                <div class="flex items-center justify-center space-x-10">
                    <a class="rounded-full bg-sky-600 p-4 text-sky-100 shadow-lg hover:bg-sky-700 active:bg-sky-800"
                       href="{{ route('analyses.edit', $analysis) }}">
                        <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"></path>
                        </svg>
                    </a>
                    @endcan
                    @can('destroy', $analysis)
                        <form action="{{ route('analyses.destroy', $analysis) }}" method="POST">
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

        <div class="flex-1 space-y-3 pt-4 md:text-center">
            <h2 class="text-2xl font-semibold leading-tight text-slate-800 dark:text-slate-200 md:text-4xl">
                {{ $analysis->title }}
            </h2>
            @if($analysis->thumbnail)
                <img src="{{ asset('storage/' . $analysis->thumbnail) }}" class="w-32 h-32 rounded-lg shadow-md mb-4">
            @endif
        </div>

        <div class="prose prose-slate mx-auto mt-6 dark:prose-invert lg:prose-xl">
            <p>{{ $analysis->content }}</p>
            <p>Autor: {{$analysis->user->name}}</p>
        </div>
    </article>
@endsection
