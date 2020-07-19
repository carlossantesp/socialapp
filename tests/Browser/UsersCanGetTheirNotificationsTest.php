<?php

namespace Tests\Browser;

use App\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanGetTheirNotificationsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function user_can_see_their_notifications_in_the_nav_bar()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_id' => $user->id,
            'data' => [
                'message' => 'Haz recibido un like',
                'link' => route('statuses.show', $status)
            ]
        ]);

        $this->browse(function (Browser $browser) use ($user, $notification, $status) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->resize(1024,768)
                    ->click('@notifications')
                    ->assertSee('Haz recibido un like')
                    ->click("@{$notification->id}")
                    ->assertUrlIs($status->path())

                    ->click('@notifications')
                    ->press("@mark-as-read-{$notification->id}")
                    ->waitFor("@mark-as-unread-{$notification->id}")
                    ->assertMissing("@mark-as-read-{$notification->id}")

                    ->press("@mark-as-unread-{$notification->id}")
                    ->waitFor("@mark-as-read-{$notification->id}")
                    ->assertMissing("@mark-as-unread-{$notification->id}")
                    ;
        });
    }
}
