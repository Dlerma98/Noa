<div>
    <input type="file" wire:model="thumbnail" class="w-full mt-1 block">

    @if ($thumbnail)
        <img src="{{ $thumbnail->temporaryUrl() }}" class="mt-2 w-32 h-32 rounded-lg shadow-md">
    @elseif ($analysis->thumbnail)
        <img src="{{ asset('storage/' . $analysis->thumbnail) }}" class="mt-2 w-32 h-32 rounded-lg shadow-md">
    @endif

    @error('thumbnail') <span class="error text-red-500">{{ $message }}</span> @enderror

    @if (session()->has('message'))
        <p class="text-green-500">{{ session('message') }}</p>
    @endif
</div>
