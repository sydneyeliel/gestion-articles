<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        Comment::create([
            'body'    => $request->body,
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Commentaire soumis, il sera visible après modération.');
    }

    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Commentaire supprimé.');
    }
}
