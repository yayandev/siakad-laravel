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

    public function show($id)
    {
        $posts = Posts::where('id', $id)->with('author:id,name,profile_picture', 'categories:id,name')->first();

        return response()->json([
            'data' => $posts
        ]);
    }

    public function destroy($id)
    {

        $posts = Posts::find($id);

        if (!$posts) {
            return redirect('/posts')->with(['error' => 'Posts not found!']);
        }
    }
}
