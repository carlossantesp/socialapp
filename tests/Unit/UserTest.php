<?php

namespace Tests\Unit;

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
}
