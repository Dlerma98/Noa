@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Análisis de Videojuegos</h1>

        <form method="GET" action="{{ route('analyses.index') }}" class="mb-6">
            <select name="score" class="border rounded p-2">
                <option value="">Puntuación mínima</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ request('score') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            <select name="genre" class="border rounded p-2">
                <option value="">Género</option>
                @foreach (['Action', 'Adventure', 'Sports', 'RPG'] as $genre)
                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                @endforeach
            </select>

            <select name="console" class="border rounded p-2">
                <option value="">Consola</option>
                @foreach (['PlayStation', 'Xbox', 'PC', 'Switch'] as $console)
                    <option value="{{ $console }}" {{ request('console') == $console ? 'selected' : '' }}>{{ $console }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($analyses as $analysis)
                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-lg font-bold">{{ $analysis->title }}</h2>
                    <p class="text-sm text-gray-600">Puntuación: {{ $analysis->score }}</p>
                    <p class="text-sm text-gray-600">Género: {{ $analysis->genre }}</p>
                    <p class="text-sm text-gray-600">Consola: {{ $analysis->console }}</p>
                    <p class="mt-2">{{ Str::limit($analysis->content, 100) }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $analyses->links() }}
        </div>
    </div>
@endsection
