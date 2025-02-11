<div class="relative w-full max-w-lg mx-auto">
    <!-- Selector de Género -->
    <div class="flex">
        <select
            wire:model.live="selectedGenre"
            class="w-full bg-gray-800 text-white border-none rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600"
        >
            <option value="">Selecciona un género</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Resultados -->
    @if(count($posts) > 0)
        <div class="w-full bg-white text-black mt-3 rounded shadow-lg max-h-96 overflow-y-auto">
            <ul>
                @foreach($posts as $post)
                    <li class="px-4 py-2 border-b border-gray-200 hover:bg-gray-100 flex items-center">
                        <a href="{{ route('posts.show', $post->id) }}" class="block flex items-center">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-16 h-16 object-cover mr-4">
                            <div>
                                <p class="font-bold">{{ $post->title }}</p>
                                <p class="text-sm text-gray-600">{{ $post->genre->name }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>


