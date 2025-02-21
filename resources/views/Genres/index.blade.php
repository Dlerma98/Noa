@extends('layouts.noa-layout')

@section('title', 'Listado de Géneros - Noa')

@if(session('status'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 mx-auto w-1/2 text-center rounded-lg shadow-md">
        <p class="font-semibold">{{ session('status') }}</p>
    </div>
@endif

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Listado de Géneros</h1>

        @if($genres->isEmpty())
            <h1 class="text-2xl font-semibold mb-6 text-center">No hay Géneros Creados.</h1>
        @endif

        @auth
            <div class="flex items-center justify-center mb-6">
                <a href="{{ route('genres.create') }}"
                   class="group rounded-full bg-sky-600 p-2 text-sky-100 shadow-lg duration-300 hover:bg-sky-700 active:bg-sky-800">
                    <svg class="h-6 w-6 duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                </a>
            </div>
        @endauth

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($genres as $genre)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                    <div class="p-5 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $genre->name }}</h2>

                        <div class="flex space-x-2">
                            <!-- Botón Editar -->
                            <a href="{{ route('genres.edit', $genre) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600 transition">
                                Editar
                            </a>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('genres.destroy', $genre) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este género?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            {{ $genres->links() }}
        </div>
    </div>
@endsection

