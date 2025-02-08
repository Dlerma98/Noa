<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadThumbnail extends Component
{
    use WithFileUploads;

    public $thumbnail; // Variable para almacenar la imagen temporal

    public function updatedThumbnail()
    {
        // Realizamos la validación para la imagen
        $this->validate();
    }

    // Método para guardar la imagen y devolver su URL
    public function save()
    {
        // Validamos primero
        $this->validate();

        if ($this->thumbnail) {
            // Guardamos la imagen en el almacenamiento público
            $imagePath = $this->thumbnail->store('thumbnails', 'public'); // Guarda en storage/thumbnails
            // Flash message para indicar que la imagen fue subida correctamente
            session()->flash('success', 'Imagen subida correctamente.');

            // Aquí solo regresamos la URL de la imagen para poder usarla en cualquier parte
            return redirect()->route('posts.create', ['image' => $imagePath]); // Redirigir con la imagen guardada
        }
    }

    public function render()
    {
        return view('livewire.upload-thumbnail');
    }
}
