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
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="w-full mt-1 block"
    >{{ old('body', $post->body) }}</x-textarea>
    <x-input-error :messages="$errors->get('body')" class="mt-2"/>
</div>

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
