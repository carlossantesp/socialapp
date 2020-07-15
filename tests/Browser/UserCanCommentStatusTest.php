<?php

namespace Tests\Browser;

use App\Comment;
use App\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_see_all_comments()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class,2)->create(['status_id' => $status->id]);

        $this->browse(function (Browser $browser) use ($status, $comments) {
            $browser->visit('/')
                    ->waitForText($status->body);

            foreach ($comments as $comment) {
                $browser->assertSee($comment->body)
                        ->assertSee($comment->user->name);
            }
        });
    }

    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($status, $user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->type('comment', 'Mi primer comentario')
                    ->press('@comment-btn')
                    ->waitForText('Mi primer comentario')
                    ->assertSee('Mi primer comentario');
        });
    }

    /**
     * @test
     */
    public function users_can_see_comments_in_real_time()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($status, $user) {
            $browser1->visit('/');

            $browser2->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->type('comment', 'Mi primer comentario')
                    ->press('@comment-btn');

            $browser1->waitForText('Mi primer comentario')
                    ->assertSee('Mi primer comentario');
        });
    }
}
