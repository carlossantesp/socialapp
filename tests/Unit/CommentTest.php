<?php

namespace Tests\Unit;

use App\Comment;
use App\Status;
use App\Traits\HasLikes;
use App\User;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_comment_belongs_to_a_user()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /**
     * @test
     */
    public function a_comment_belongs_to_a_status()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(Status::class, $comment->status);
    }

    /**
     * @test
     */
    public function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUsesTrait(HasLikes::class, Comment::class);
    }

    /**
     * @test
     */
    public function a_comment_must_have_a_path()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals(route('statuses.show', $comment->status_id)."#comment-". $comment->id, $comment->path());
        // statuses/id#comment-1
    }
}
