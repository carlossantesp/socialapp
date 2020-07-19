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
                    ->pause(1000)
                    ->assertSeeIn('@comment-likes-count',0);
        });
    }

    /**
     * @test
     */
    public function users_can_likes_and_unlikes_comment_in_real_time()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($comment, $user) {
            $browser1->visit('/');

            $browser2->loginAs($user)
                    ->visit('/')
                    ->waitForText($comment->body)
                    ->assertSeeIn('@comment-likes-count',0)
                    ->press('@comment-like-btn')
                    ->waitForText('TE GUSTA');

            $browser1->assertSeeIn('@comment-likes-count',1);

            $browser2->press('@comment-like-btn')
                    ->waitForText('ME GUSTA');

            $browser1->pause(1000)->assertSeeIn('@comment-likes-count',0);
        });
    }
}
