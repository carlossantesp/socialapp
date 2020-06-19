<?php

namespace Tests\Browser;

use App\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_see_all_statuses_on_the_homepage()
    {
        $statuses = factory(Status::class,3)->create();
        $this->browse(function (Browser $browser) use ($statuses) {
            $browser->visit('/')
                    ->waitForText($statuses->first()->body);
            
            foreach($statuses as $status){
                $browser->assertSee($status->body);
            }
        });
    }
}
