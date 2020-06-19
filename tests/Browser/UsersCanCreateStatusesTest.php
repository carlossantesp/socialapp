<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * @test
     */
    public function users_can_create_statuses()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body','Mi primer status')
                    ->press('#create-status')
                    ->waitForText('Mi primer status')
                    ->assertSee('Mi primer status')
                    ->assertSee($user->name);
        });
    }
}
