<x-app-layout>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4 mx-auto w-1/2 text-center rounded-lg shadow-md">
            <p class="font-semibold">{{ session('status') }}</p>
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit a analysis') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('analyses.update', $analysis) }}"
                          class="space-y-4 max-w-xl"
                    >

                        @include("analyses.form-fields")

                        <div class="mt-4">
                            <x-input-label for="thumbnail" :value="__('Thumbnail')" />

                            <!-- Llamamos al componente de Livewire -->
                            @livewire('Analysis.image-uploader', ['analysis' => $analysis])

                            <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                        </div>

                        <x-primary-button type="submit" class="mt-4">{{__('Save')}}</x-primary-button>

                        @csrf
                        @method('PATCH')

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
