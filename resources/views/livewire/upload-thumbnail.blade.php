<div>
    <!-- Input para subir la imagen -->
    <x-input-label for="thumbnail" :value="__('Thumbnail')" />
    <input type="file" wire:model="thumbnail" class="w-full mt-1 block">

    <!-- Vista previa de la imagen seleccionada -->
    @if ($thumbnail)
        <img src="{{ $thumbnail->temporaryUrl() }}" class="mt-2 w-32 h-32 rounded-lg shadow-md">
    @endif

    <!-- Mensajes de error si la validación falla -->
    <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />

    <!-- Mensaje de éxito cuando la imagen se sube correctamente -->
    @if (session()->has('success'))
        <p class="text-green-500 mt-2">{{ session('success') }}</p>
    @endif

    <!-- Botón para guardar -->
    <button wire:click="save" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">
        Guardar Imagen
    </button>
</div>
