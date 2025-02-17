<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Análisis del Usuario -->
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Post Realizados</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ auth()->user()->posts ? auth()->user()->posts->count() : 0 }}</p>
                </div>

                <!-- Análisis del Usuario -->
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Análisis Realizados</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ auth()->user()->analysis ? auth()->user()->analysis->count() : 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
