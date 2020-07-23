<?php

namespace Tests\Unit;

use App\Friendship;
use App\Status;
use App\User;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function route_key_name_is_set_to_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name',$user->getRouteKeyName(),'The route key name must be name');
    }

    /**
     * @test
     */
    public function user_has_a_like_to_their_profile()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(route('users.show', $user), $user->link());
    }
    /**
     * @test
     */
    public function user_has_an_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('/img/default-avatar.jpg', $user->avatar());
        $this->assertEquals('/img/default-avatar.jpg', $user->avatar);
    }

    /**
     * @test
     */
    public function a_user_has_many_statuses()
    {
        $user = factory(User::class)->create();

        factory(Status::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Status::class, $user->statuses->first());
    }

    /**
     * @test
     */

     public function a_user_can_send_friend_requests()
     {
         $sender = factory(User::class)->create();
         $recipient = factory(User::class)->create();

         $friendship = $sender->sendFriendRequestTo($recipient);

         $this->assertTrue($friendship->sender->is($sender));
         $this->assertTrue($friendship->recipient->is($recipient));
     }

    /**
     * @test
     */

    public function a_user_can_accept_friend_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $friendship = $recipient->acceptFriendRequestFrom($sender);

        $this->assertEquals('accepted', $friendship->status);
    }

    /**
     * @test
     */

    public function a_user_can_deny_friend_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $friendship = $recipient->denyFriendRequestFrom($sender);

        $this->assertEquals('denied', $friendship->status);
    }

    /**
     * @test
     */
    public function a_user_can_get_all_their_friend_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $this->assertCount(0, $recipient->friendshipRequestsSent);
        $this->assertCount(1, $recipient->friendshipRequestsReceived);
        $this->assertInstanceOf(Friendship::class, $recipient->friendshipRequestsReceived->first());

        $this->assertCount(1, $sender->friendshipRequestsSent);
        $this->assertCount(0, $sender->friendshipRequestsReceived);
        $this->assertInstanceOf(Friendship::class, $sender->friendshipRequestsSent->first());
    }
}
