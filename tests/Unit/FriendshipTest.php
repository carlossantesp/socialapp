<?php

namespace Tests\Unit;

use App\Friendship;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;

class FriendshipTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_friendship_request_belongs_to_a_sender()
    {
        $sender = factory(User::class)->create();

        $friendship = factory(Friendship::class)->create([
            'sender_id' => $sender->id,
        ]);

        $this->assertInstanceOf(User::class, $friendship->sender);
    }

    /**
     * @test
     */
    public function a_friendship_request_belongs_to_a_recipient()
    {
        $recipient = factory(User::class)->create();

        $friendship = factory(Friendship::class)->create([
            'recipient_id' => $recipient->id,
        ]);

        $this->assertInstanceOf(User::class, $friendship->recipient);
    }
}
