<?php

namespace App\Http\Controllers;

use App\Http\Requests\Analysis\StoreAnalysisRequest;
use App\Http\Requests\Analysis\UpdateAnalysisRequest;
use App\Models\Analysis;
use App\Models\Genre;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;


class AnalysisController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {

        $analyses = Analysis::query();
        // Obtener los posts ordenados
        $analyses = $analyses->orderBy('created_at', 'desc')->paginate(12);

        return view('analyses.index', compact('analyses'));
    }

    public function show(Analysis $analysis)
    {

        return view('analyses.show', compact('analysis'));

    }

    public function create()
    {
        $genres = Genre::all();
        return view('analyses.create', [
            'genres' => $genres,
            'analysis' => new Analysis()
        ]);
    }

    public function store(StoreAnalysisRequest $request)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'redactor'])) {
            abort(403, 'No tienes permiso para crear posts.');
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = null; // Se actualizará después con Livewire

        // Crear el post sin imagen
        $analysis = Analysis::create($data);

        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('analyses.edit', $analysis->id)->with('status', 'Analisis creado con éxito. Ahora sube una imagen si lo deseas.');
    }


    public function myAnalyses() {
        $analyses = Analysis::where('user_id', auth()->user()->id)->get();
        return view('analyses.myanalyses', compact('analyses'));
    }

    public function edit(Analysis $analysis)
    {
        $this->authorize('update', $analysis);
        $genres = Genre::all();
        return view('analyses.edit', compact('analysis','genres'));
    }


    public function update(UpdateAnalysisRequest $request, Analysis $analysis)
    {

        $analysis -> update($request->validated());

        return to_route('analyses.show', $analysis)->with('status', 'Analysis actualizado exitosamente!');

    }

    public function destroy(Analysis $analysis)
    {
        $this->authorize('destroy', $analysis);
        $analysis -> delete();
        return redirect()->route('analyses.index')->with('status', 'Analysis eliminado exitosamente!');
    }

}
