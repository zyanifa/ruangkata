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
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id
        ]);
        
        return redirect()->back()
            ->with('toast', [
                'message' => $request->parent_id ? 'Balasan berhasil ditambahkan!' : 'Komentar berhasil ditambahkan!',
                'type' => 'success'
            ]);
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
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'content' => 'required|string'
        ]);
        
        $comment->update([
            'content' => $request->content
        ]);
        
        return redirect()->back()
            ->with('toast', [
                'message' => $comment->parent_id ? 'Balasan berhasil diubah!' : 'Komentar berhasil diubah!',
                'type' => 'success'
            ]);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
        
        $isReply = $comment->parent_id !== null;
        $comment->delete();
        
        return redirect()->back()
            ->with('toast', [
                'message' => $isReply ? 'Balasan berhasil dihapus!' : 'Komentar berhasil dihapus!',
                'type' => 'success'
            ]);
    }
}