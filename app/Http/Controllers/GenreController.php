<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {

        $genres = Genre::orderBy('created_at', 'desc')->paginate(12);
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres|max:255',
        ]);

        Genre::create($request->all());

        return redirect()->route('genres.index')->with('success', 'Género creado con éxito.');
    }

    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name,' . $genre->id . '|max:255',
        ]);

        $genre->update($request->all());

        return redirect()->route('genres.index')->with('success', 'Género actualizado con éxito.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('genres.index')->with('success', 'Género eliminado.');
    }
}
