<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'           => Post::count(),
            'categories'      => Category::count(),
            'comments'        => Comment::count(),
            'pending'         => Comment::where('status', 'pending')->count(),
        ];

        $recentPosts = Post::with(['category', 'comments'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}
