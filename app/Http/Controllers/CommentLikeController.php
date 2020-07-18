<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function store(Comment $comment)
    {
        $comment->like();
    }

    public function destroy(Comment $comment)
    {
        $comment->unlike();
    }
}
