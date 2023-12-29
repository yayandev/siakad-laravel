<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Posts::all();

        return response()->json([
            'data' => $posts
        ]);
    }

    public function show($slug)
    {
        $posts = Posts::where('slug', $slug)->with('author:id,name,profile_picture', 'categories:id,name')->first();

        return response()->json([
            'data' => $posts
        ]);
    }
}
