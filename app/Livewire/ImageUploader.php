<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $thumbnail;
    public $post;

    public function mount($post)
    {
        $this->post = $post;
    }

    public function updatedThumbnail()
    {
        $this->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Guardar la imagen en el almacenamiento
        $path = $this->thumbnail->store('thumbnails', 'public');

        // Actualizar la URL en la base de datos
        $this->post->update(['thumbnail' => $path]);

        session()->flash('message', 'Imagen subida con éxito.');
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
