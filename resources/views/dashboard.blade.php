<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @if(auth()->user()->hasRole('redactor'))
                    <!-- Post del Usuario (para redactores) -->
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Tus Posts</h3>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ auth()->user()->posts ? auth()->user()->posts->count() : 0 }}
                        </p>
                    </div>

                    <!-- Análisis del Usuario (para redactores) -->
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Tus Análisis</h3>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">
                            {{ auth()->user()->analyses ? auth()->user()->analyses->count() : 0 }}
                        </p>
                    </div>
                @else
                    <!-- Total de Posts (para lectores) -->
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Total de Posts</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ \App\Models\Post::count() }}
                        </p>
                    </div>

                    <!-- Total de Análisis (para lectores) -->
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700">Total de Análisis</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ \App\Models\Analysis::count() }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
