<div>


    <x-input-label for="name" :value="__('Name')"/>
    <x-text-input id="name"
                  name="name"
                  type="text"
                  value="{{old('name' , $genre->name)}}"
                  class="w-full mt-1 block"
    />
    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
</div>
