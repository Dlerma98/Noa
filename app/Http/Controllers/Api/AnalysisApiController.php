<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnalysisResource;
use App\Models\Analysis;
use Illuminate\Http\Request;

class AnalysisApiController extends Controller
{
    /**
     * @group Análisis
     *
     * API para gestionar análisis
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Análisis del mercado",
     *       "description": "Detalles del análisis",
     *       "created_at": "2025-02-21 14:00:00",
     *       "updated_at": "2025-02-21 15:00:00"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $analyses = Analysis::latest()->paginate(10);
        return AnalysisResource::collection($analyses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
