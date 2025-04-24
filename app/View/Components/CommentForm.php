<?php

namespace App\View\Components;

use App\Models\Post;
use App\Models\Comment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentForm extends Component
{
    public $post;
    public $parentComment;

    public function __construct(Post $post, Comment $parentComment = null)
    {
        $this->post = $post;
        $this->parentComment = $parentComment;
    }

    public function render(): View|Closure|string
    {
        return view('components.comment-form');
    }
}