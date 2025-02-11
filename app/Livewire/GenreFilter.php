<?php
namespace App\Livewire;

use App\Models\Post;
use App\Models\Genre;
use Livewire\Component;

class GenreFilter extends Component
{
    public $genres = [];
    public $selectedGenre = '';
    public $posts = [];

    public function mount()
    {
        $this->genres = Genre::all(); // Cargar todos los géneros
    }

    public function updatedSelectedGenre()
    {
        if (!empty($this->selectedGenre)) {
            $this->posts = Post::where('genre_id', $this->selectedGenre)->get();
        } else {
            $this->posts = [];
        }
    }

    public function render()
    {

        return view('livewire.genre-filter', [
            'posts' => $this->posts,
            'genres' => $this->selectedGenre,
        ]);
    }
}
