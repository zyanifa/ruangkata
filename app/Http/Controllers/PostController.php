<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $showFollowedOnly = $user && Session::get('show_followed_only', false);
    
        $query = Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->withCount('claps')
            ->latest();
            
        // Only filter by followed users if the toggle is on
        if ($user && $showFollowedOnly) {
            $ids = $user->following()->pluck('users.id')->toArray();
            $ids[] = $user->id;
            $query->whereIn('user_id', $ids);
        }
    
        $posts = $query->simplePaginate(5);
        $categories = Category::orderBy('name')->get(); // Sort categories alphabetically
        
        if ($request->ajax() || $request->has('ajax')) {
            return view('post.partials.post-list', ['posts' => $posts])->render();
        }
        
        return view('post.index', [
            'posts' => $posts,
            'categories' => $categories, // Pass sorted categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(); // Sort categories alphabetically
        
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

        $post = Post::create($data);

        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('post.show', ['username' => $post->user->username, 'post' => $post->slug])
            ->with('toast', [
                'message' => 'Post berhasil dibuat!',
                'type' => 'success'
            ]);
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
         
         $categories = Category::orderBy('name')->get(); // Sort categories alphabetically
         
         return view('post.show', [
             'post' => $post,
             'comments' => $comments,
             'categories' => $categories, // Pass sorted categories
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
        $categories = Category::orderBy('name')->get(); // Sort categories alphabetically
        
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
        $post->update($data);
        
        if ($request->hasFile('image')) {
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }
        
        return redirect()->route('post.show', ['username' => $post->user->username, 'post' => $post->slug])
            ->with('toast', [
                'message' => 'Post berhasil diperbarui!',
                'type' => 'success'
            ]);
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
        
        return redirect()->route('dashboard')
            ->with('toast', [
                'message' => 'Post berhasil dihapus!',
                'type' => 'success'
            ]);
    }

    public function category(Request $request, Category $category)
    {
        $user = auth()->user();
        $showFollowedOnly = $user && Session::get('show_followed_only', false);
    
        $query = $category->posts()
            ->where('published_at', '<=', now())
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest();
    
        // Only filter by followed users if the toggle is on
        if ($user && $showFollowedOnly) {
            $ids = $user->following()->pluck('users.id')->toArray();
            $ids[] = $user->id;
            $query->whereIn('user_id', $ids);
        }
        
        $posts = $query->simplePaginate(5);
        $categories = Category::orderBy('name')->get(); // Sort categories alphabetically
    
        if ($request->ajax() || $request->has('ajax')) {
            return view('post.partials.post-list', ['posts' => $posts])->render();
        }
        
        return view('post.index', [
            'posts' => $posts,
            'categories' => $categories, // Pass sorted categories
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
        
        return view('post.search', [
            'posts' => $posts,
            'searchQuery' => $query,
        ]);
    }

        public function toggleFollowedFilter(Request $request)
        {
            // Check if the value is "1" (on) or "0" (off)
            $showFollowedOnly = $request->input('show_followed_only') === '1';
            Session::put('show_followed_only', $showFollowedOnly);
            
            return response()->json(['success' => true, 'followed_only' => $showFollowedOnly]);
        }
}