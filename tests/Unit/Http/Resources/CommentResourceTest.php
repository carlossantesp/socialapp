<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Comment;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_comment_resources_must_have_the_necessary_fields()
    {
        $comment = factory(Comment::class)->create();

        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );
        $this->assertEquals(
            $comment->user->name,
            $commentResource['user_name']
        );
        $this->assertEquals(
            '/img/default-avatar.jpg',
            $commentResource['user_avatar']
        );
    }
}
