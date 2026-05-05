<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user:id,name', 'category:id,name,slug'])
            ->withCount('approvedComments')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(8);

        return response()->json($posts);
    }

    public function show(int $id)
    {
        $post = Post::with([
                'user:id,name',
                'category:id,name,slug',
                'approvedComments.user:id,name',
            ])
            ->whereNotNull('published_at')
            ->findOrFail($id);

        return response()->json($post);
    }

    public function storeComment(Request $request, int $id)
    {
        $post = Post::whereNotNull('published_at')->findOrFail($id);

        $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $comment = Comment::create([
            'body'    => $request->body,
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'status'  => 'pending',
        ]);

        return response()->json($comment->load('user:id,name'), 201);
    }
}
