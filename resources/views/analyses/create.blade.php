<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a new Analysis') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('analyses.store') }}"
                          class="space-y-4 max-w-xl"
                    >
                        @include("analyses.form-fields")
                        {{--}} <div>
                             <x-input-label for="published_at" :value="__('Published At')" />
                             <x-text-input id="published_at"
                                           type="datetime-local"
                                           name="published_at"
                                           value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                           class="w-full mt-1 block" />
                             <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                         </div>
                         --}}
                        <x-primary-button type="submit" class="mt-4">{{__('Save')}}</x-primary-button>
                    @csrf
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
