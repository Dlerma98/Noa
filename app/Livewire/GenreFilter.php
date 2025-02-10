<?php
namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class GenreFilter extends Component
{
    public $search = '';
    public $results = [];
    public $errorMessage = '';

    public function searchGenre()
    {
        if (strlen($this->search) > 2) {
            $this->results = Post::whereHas('genre', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->get();

            if ($this->results->isEmpty()) {
                $this->errorMessage = 'No se encontraron Posts con dicho género.';
            } else {
                $this->errorMessage = '';
            }
        } else {
            $this->errorMessage = 'Escribe al menos 3 caracteres para buscar.';
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.genre-filter', ['posts' => $this->results]);
    }
}
