<div class="relative w-full max-w-lg mx-auto">
    <!-- Campo de búsqueda -->
    <div class="flex">
        <input
            type="text"
            wire:model="search"
            placeholder="Buscar por género..."
            class="w-full bg-gray-800 text-white border-none rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600"
        >
        <button
            wire:click="searchGenre"
            class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-800 transition"
        >
            Buscar
        </button>
    </div>

    <!-- Mensaje de error -->
    @if ($errorMessage)
        <div class="text-red-600 mt-2">
            {{ $errorMessage }}
        </div>
    @endif

    <!-- Resultados del buscador -->
    @if(!empty($posts))
        <div class="absolute w-full bg-white text-black mt-1 rounded shadow-lg z-10 max-h-64 overflow-y-auto">
            <ul>
                @foreach($posts as $post)
                    <li class="px-4 py-2 border-b border-gray-200 hover:bg-gray-100 flex items-center">
                        <a href="{{ route('posts.show', $post->id) }}" class="block flex items-center">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->name }}" class="w-16 h-16 object-cover mr-4">
                            <div>
                                <p>{{ $post->name }}</p>
                                <p>{{ $post->genre->name }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

