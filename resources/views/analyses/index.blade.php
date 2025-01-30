@extends('layouts.noa-layout')

@section('title', 'Análisis de Videojuegos')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold mb-6 text-center">Análisis de Videojuegos</h1>

        @if($analyses->isEmpty())
            <p class="text-center text-gray-600">No hay análisis disponibles.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($analyses as $analysis)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $analysis->title }}</h2>
                        <p class="text-gray-600">{{ $analysis->genre }}</p>
                        <a href="{{ route('analyses.show', $analysis) }}" class="text-indigo-500 font-medium hover:underline">
                            Leer más
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

