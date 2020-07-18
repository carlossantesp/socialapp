<?php

namespace Tests\Browser;

use App\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_users_cannot_like_statuses()
    {
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
                    ->waitForText($status->body)
                    ->press('@like-btn')
                    ->assertPathIs('/login');
        });
    }

    /**
     * @test
     */
    public function users_can_like_and_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status, $user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->assertSeeIn('@likes-count',0)
                    ->press('@like-btn')
                    ->waitForText('TE GUSTA')
                    ->assertSee('TE GUSTA')
                    ->assertSeeIn('@likes-count',1)

                    ->press('@like-btn')
                    ->waitForText('ME GUSTA')
                    ->assertSee('ME GUSTA')
                    ->assertSeeIn('@likes-count',0);
        });
    }

    /**
     * @test
     */
    public function users_can_likes_and_unlikes_in_real_time()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($status, $user) {
            $browser1->visit('/');

            $browser2->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->assertSeeIn('@likes-count',0)
                    ->press('@like-btn')
                    ->waitForText('TE GUSTA');

            $browser1->assertSeeIn('@likes-count',1);

            $browser2->press('@like-btn')
                    ->waitForText('ME GUSTA');

            $browser1->assertSeeIn('@likes-count',0);
        });
    }
}
