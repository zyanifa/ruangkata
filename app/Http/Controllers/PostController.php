<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $query =  Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->withCount('claps')
            ->latest();
        if ($user) {
            $ids = $user->following()->pluck('users.id')->toArray();
            $ids[] = $user->id;
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        
        return view('post.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();

        // Sanitize the content to remove harmful HTML tags
        // $data['content'] = strip_tags($data['content'], '<p><a><b><i><strong><em><ul><ol><li><br><h1><h2><h3><h4><h5><h6><pre><code><img>');

        $post = Post::create($data);

        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('post.show', ['username' => $post->user->username, 'post' => $post->slug]);
    }

    /**
     * Display the specified resource.
     */
     public function show(string $username, Post $post)
     {
         $comments = $post->comments()
             ->with(['user', 'replies.user'])
             ->latest()
             ->paginate(5);
         
         return view('post.show', [
             'post' => $post,
             'comments' => $comments,
         ]);
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::get();
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $data = $request->validated();

        // Sanitize the content to allow only safe HTML tags
        // $data['content'] = strip_tags($data['content'], '<p><a><b><i><strong><em><ul><ol><li><br><h1><h2><h3><h4><h5><h6><pre><code><img>');

        $post->update($data);

        if ($data['image'] ?? false) {
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }

        return redirect()->route('post.show', ['username' => $post->user->username, 'post' => $post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $post->delete();

        return redirect()->route('dashboard');
    }

    public function category(Category $category)
    {
        $user = auth()->user();

        $query = $category->posts()
            ->where('published_at', '<=', now())
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest();

        if ($user) {
            $ids = $user->following()->pluck('users.id');
            $ids[] = $user->id;
            $query->whereIn('user_id', $ids);
        }
        $posts = $query->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $posts = Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->where(function($q) use ($query) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($query) . '%'])
                  ->orWhereRaw('LOWER(short_description) LIKE ?', ['%' . strtolower($query) . '%']);
            })
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5)
            ->appends(['query' => $query]);
        
        return view('post.index', [
            'posts' => $posts,
            'searchQuery' => $query
        ]);
    }
}
