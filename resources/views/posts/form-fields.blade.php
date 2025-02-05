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

{{--AÑADIR CATEGORIAS A LOS POST MAS ADELANTE--}}
{{--}}
<div>
    <x-input-label for="category_id" :value="__('Category')" />
    <select name="category_id" id="category_id" class="w-full mt-1 block">
        <option value="" disabled selected>Choose a category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2"/>
</div>
--}}
