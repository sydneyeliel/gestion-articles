<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::with(['user', 'category', 'approvedComments'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if (request('search')) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('body', 'like', '%' . request('search') . '%');
            });
        }

        if (request('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', request('category')));
        }

        $posts      = $query->latest('published_at')->paginate(8)->withQueryString();
        $categories = Category::withCount(['posts' => fn($q) => $q->whereNotNull('published_at')])->get();
        $recent     = Post::with('user')->whereNotNull('published_at')->latest('published_at')->take(5)->get();
        $totalPosts = Post::whereNotNull('published_at')->count();

        return view('posts.index', compact('posts', 'categories', 'recent', 'totalPosts'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['user', 'category', 'approvedComments.user'])
            ->where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        $related = Post::with(['user', 'category'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'related'));
    }
}
