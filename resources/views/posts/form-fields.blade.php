<div>


    <x-input-label for="title" :value="__('Title')"/>
    <x-text-input id="title"
                  name="title"
                  type="text"
                  value="{{old('title' , $post->title)}}"
                  class="w-full mt-1 block"
    />
    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
</div>


<div>
    <x-input-label for="excerpt" :value="__('excerpt')"/>
    <x-text-input id="excerpt"
                  name="excerpt"
                  type="text"
                  value="{{old('excerpt' , $post->excerpt)}}"
                  class="w-full mt-1 block"
    />
    <x-input-error :messages="$errors->get('excerpt')" class="mt-2"/>
</div>

<div>
    <x-input-label for="content" :value="__('content')" />
    <x-textarea id="content"
                name="content"
                class="w-full mt-1 block"
    >{{ old('content', $post->content) }}</x-textarea>
    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
</div>

<div>
    <x-input-label for="category" :value="__('Category')"/>
    <select id="category" name="category" class="w-full mt-1 block border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        @foreach(['PlayStation', 'Xbox', 'PC', 'Switch'] as $category)
            <option value="{{ $category }}" {{ old('category', $post->category) == $category ? 'selected' : '' }}>
                {{ $category }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category')" class="mt-2"/>
</div>


<div>
    <x-input-label for="type" :value="__('Type')"/>
    <select id="type" name="type" class="w-full mt-1 block border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        @foreach(['Exclusive', 'Multiplatform'] as $type)
            <option value="{{ $type }}" {{ old('type', $post->type) == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('type')" class="mt-2"/>
</div>

