<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'comments'])->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'body'        => ['required', 'string', 'min:10'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'published'   => ['nullable', 'boolean'],
        ]);

        $data['slug']    = Str::slug($data['title']) . '-' . time();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $data['published_at'] = $request->boolean('published') ? now() : null;
        unset($data['published']);

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Article publié avec succès !');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'body'        => ['required', 'string', 'min:10'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'published'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($data['image']);
        }

        $data['published_at'] = $request->boolean('published') ? ($post->published_at ?? now()) : null;
        unset($data['published']);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Article modifié avec succès !');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Article supprimé.');
    }
}
