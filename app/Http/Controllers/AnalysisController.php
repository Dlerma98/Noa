<?php

namespace App\Http\Controllers;

use App\Http\Requests\Analysis\StoreAnalysisRequest;
use App\Http\Requests\Analysis\UpdateAnalysisRequest;
use App\Http\Requests\Post\UpdatePostRequest;
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
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = null; // Se actualizará después con Livewire

        // Crear el post sin imagen
        $analysis = Analysis::create($data);

        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('analyses.edit', $analysis->id)->with('status', 'Analisis creado con éxito. Ahora sube una imagen.');
    }


    public function myAnalyses() {
        $analyses = Analysis::where('user_id', auth()->user()->id)->get();
        return view('analyses.myanalyses', compact('analyses'));
    }

    public function edit(Analysis $analysis)
    {
        return view('analyses.edit', compact('analysis'));
    }


    public function update(UpdateAnalysisRequest $request, Analysis $analysis)
    {

        $analysis -> update($request->validated());

        return to_route('analyses.show', $analysis)->with('status', 'Analysis updated successfully!');

    }

}
