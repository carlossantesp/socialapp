<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function store(Comment $comment)
    {
        $comment->likes()->create([
            'user_id' => auth()->id(),
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->likes()->where([
            'user_id' => auth()->id(),
        ])->delete();
    }
}
