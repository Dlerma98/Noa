<?php

namespace App\Http\Controllers;

use App\Http\Requests\Analysis\StoreAnalysisRequest;
use App\Models\Analysis;
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
        return view('analyses.create', ['analysis' => new Analysis()]);
    }

    public function store(StoreAnalysisRequest $request)
    {
        $data = $request->validated();

        Analysis::create($data);

        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('analyses.index')->with('status', 'Post creado con éxito. Ahora sube una imagen.');
    }


    public function myAnalyses() {
        $analyses = Analysis::where('user_id', auth()->user()->id)->get();
        return view('analyses.myanalyses', compact('analyses'));
    }

}
