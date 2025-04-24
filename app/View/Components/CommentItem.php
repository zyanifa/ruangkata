<?php

namespace App\View\Components;

use App\Models\Comment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentItem extends Component
{
    public $comment;
    public $post;

    public function __construct(Comment $comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    public function render(): View|Closure|string
    {
        return view('components.comment-item');
    }
}