@extends('layouts.noa-layout')

@section('title', 'Análisis de Videojuegos - Noa')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Análisis de Videojuegos</h1>

        @auth
            <div class="flex items-center justify-center">
                <a
                    href="{{ route('analyses.create') }}"
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

        @if($analyses->isEmpty())
            <p class="text-center text-gray-600">No hay análisis disponibles.</p>
        @else
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($analyses as $analysis)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                        <div class="p-5">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $analysis->title }}</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $analysis->console }}</p>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $analysis->type }}</p>
                            <a href="{{ route('analyses.show', $analysis) }}"
                               class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                                Leer más
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

