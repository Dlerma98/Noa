<div>


    <x-input-label for="title" :value="__('Title')"/>
    <x-text-input id="title"
                  name="title"
                  type="text"
                  value="{{old('title' , $analysis->title)}}"
                  class="w-full mt-1 block"
    />
    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
</div>


<div>
    <x-input-label for="content" :value="__('content')" />
    <x-textarea id="content"
                name="content"
                class="w-full mt-1 block"
    >{{ old('content', $analysis->content) }}</x-textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
</div>

<div>
    <x-input-label for="score" :value="__('Score')" />

    <input type="range" id="score" name="score"
           min="0" max="100"
           value="{{ old('score', $analysis->score) }}"
           class="w-full mt-1 block"
           oninput="document.getElementById('scoreValue').innerText = this.value"
    >

    <!-- Muestra el valor actual del slider -->
    <span id="scoreValue" class="text-gray-700 dark:text-gray-300">{{ old('score', $analysis->score) }}</span>

    <x-input-error :messages="$errors->get('score')" class="mt-2"/>
</div>

<div>
    <x-input-label for="console" :value="__('Console')"/>
    <select id="console" name="console" class="w-full mt-1 block border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        @foreach(['PlayStation', 'Xbox', 'PC', 'Switch'] as $console)
            <option value="{{ $console }}" {{ old('console', $analysis->console) == $console ? 'selected' : '' }}>
                {{ $console }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('console')" class="mt-2"/>
</div>


<div>
    <x-input-label for="type" :value="__('Type')"/>
    <select id="type" name="type" class="w-full mt-1 block border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        @foreach(['Review', 'Retro','News'] as $type)
            <option value="{{ $type }}" {{ old('type', $analysis->type) == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('type')" class="mt-2"/>
</div>


<div>
    <x-input-label for="genre" :value="__('Genre')"/>
    <select id="genre" name="genre_id"
            class="w-full mt-1 block border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        <option value="">-- Select Genre --</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->id }}" {{ old('genre_id', $analysis->genre_id) == $genre->id ? 'selected' : '' }}>
                {{ $genre->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('genre_id')" class="mt-2"/>
</div>
