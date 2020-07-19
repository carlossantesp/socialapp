<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class CanGetNotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_users_cannot_access_notifications()
    {
        $this->getJson(route('notifications.index'))
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function authenticated_users_can_get_their_notifications()
    {
        $user = factory(User::class)->create();

        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->getJson(route('notifications.index'))
            ->assertJson([
                [
                    'data' => [
                        'link' => $notification->data['link'],
                        'message' => $notification->data['message'],
                    ]
                ]
            ]);
    }
}
