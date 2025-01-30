<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Post;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        // Filtrar por puntaje, género o consola
        $analyses = Analysis::query()
            ->when($request->input('score'), fn($query, $score) => $query->where('score', '>=', $score))
            ->when($request->input('genre'), fn($query, $genre) => $query->where('genre', $genre))
            ->when($request->input('console'), fn($query, $console) => $query->where('console', $console))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('analyses.index', compact('analyses'));
    }

    public function show(Analysis $analysis)
    {

        return view('analyses.show', compact('analysis'));

    }

    public function create()
    {
        return view('analyses.create', ['post' => new Post()]);
    }

}
