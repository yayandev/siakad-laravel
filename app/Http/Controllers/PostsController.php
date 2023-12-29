<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Posts::paginate(4);

        return view('posts.index', compact('categories', 'posts'));
    }

    public function destroy($id)
    {
        $posts = Posts::find($id);
        if (!$posts) {
            return redirect('/posts')->with(['error' => 'Posts not found!']);
        }

        if ($posts->image != null) {
            Storage::delete('public/posts/' . basename($posts->image));
        }

        $posts->delete();
        return redirect('/posts')->with(['success' => 'Posts deleted successfully!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_category' => 'required',
        ]);

        $id_user = auth()->user()->id;

        $slug = str_replace(' ', '-', strtolower($request->title));

        $posts = Posts::where('slug', $slug)->first();

        if ($posts) {
            return redirect('/posts')->with(['error' => 'Title already exists!']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image->storeAs('public/posts', $image->hashName());

            Posts::create([
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image->hashName(),
                'id_user' => $id_user,
                'id_category' => $request->id_category,
                'slug' => $slug
            ]);

            return redirect('/posts')->with(['success' => 'Posts created successfully!']);
        }

        Posts::create([
            'title' => $request->title,
            'body' => $request->body,
            'id_user' => $id_user,
            'id_category' => $request->id_category,
            'slug' => $slug
        ]);

        return redirect('/posts')->with(['success' => 'Posts created successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_category' => 'required',
        ]);

        $posts = Posts::find($id);

        if (!$posts) {
            return redirect('/posts')->with(['error' => 'Posts not found!']);
        }

        if ($posts->title == $request->title) {
            $slug = $posts->slug;
        } else {
            $slug = str_replace(' ', '-', strtolower($request->title));

            $posts = Posts::where('slug', $slug)->first();

            if ($posts) {
                return redirect('/posts')->with(['error' => 'Title already exists!']);
            }
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image->storeAs('public/posts', $image->hashName());

            Storage::delete('public/posts/' . basename($posts->image));

            $posts->update([
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image->hashName(),
                'id_category' => $request->id_category,
            ]);

            return redirect('/posts')->with(['success' => 'Posts updated successfully!']);
        }

        $posts->update([
            'title' => $request->title,
            'body' => $request->body,
            'id_category' => $request->id_category,
        ]);

        return redirect('/posts')->with(['success' => 'Posts updated successfully!']);
    }
}
