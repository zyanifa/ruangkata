<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|min:2',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        $post->comments()->save($comment);

        return redirect(url()->previous() . '#comments-section')->with('success', 'Comment posted successfully!');
    }

    public function edit(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'content' => $comment->content
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'content' => 'required|min:2',
        ]);

        $comment->content = $validated['content'];
        $comment->edited_at = now();
        $comment->save();

        return redirect(url()->previous() . '#comment-' . $comment->id)->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return redirect(url()->previous() . '#comments-section')->with('success', 'Comment deleted successfully!');
    }
}