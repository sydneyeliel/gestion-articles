<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');

        $query = Comment::with(['user', 'post'])->latest();

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'approved') {
            $query->where('status', 'approved');
        }

        $comments = $query->paginate(20)->withQueryString();
        $pending  = Comment::where('status', 'pending')->count();

        return view('admin.comments.index', compact('comments', 'filter', 'pending'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Commentaire approuvé.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }
}
