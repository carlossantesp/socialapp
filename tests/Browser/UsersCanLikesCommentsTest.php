<?php

namespace Tests\Browser;

use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikesCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_like_and_unlike_comments()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser) use ($comment, $user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($comment->body)
                    ->assertSeeIn('@comment-likes-count',0)
                    ->press('@comment-like-btn')
                    ->waitForText('TE GUSTA')
                    ->assertSee('TE GUSTA')
                    ->assertSeeIn('@comment-likes-count',1)

                    ->press('@comment-like-btn')
                    ->waitForText('ME GUSTA')
                    ->assertSee('ME GUSTA')
                    ->assertSeeIn('@comment-likes-count',0);
        });
    }
}
