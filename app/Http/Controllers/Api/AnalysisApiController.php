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
     *      "content": => "Contenido del analisis que hemos creado anteriormente",
     *      "score": => "75"
     *      "console": => "Xbox"
     *      "type": => "Review"
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


    /**
     * Display the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
}
