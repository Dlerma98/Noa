<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * @group Posts
     *
     * API para gestionar posts
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Mi primer post",
     *       "content": "Este es el contenido del post",
     *       "created_at": "2025-02-21 12:00:00",
     *       "updated_at": "2025-02-21 12:30:00"
     *     }
     *   ]
     * }
     */

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return PostResource::collection($posts);
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
