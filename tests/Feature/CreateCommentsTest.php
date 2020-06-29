<?php

namespace Tests\Feature;

use App\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_users_cannot_create_comments()
    {
        $status = factory(Status::class)->create();

        $response = $this->postJson(route('statuses.comments.store',$status), ['body' => 'Mi primer comentario']);

        $response->assertStatus(401);
    }


    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {
        // $this->withoutExceptionHandling();

        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->postJson(route('statuses.comments.store',$status), ['body' => 'Mi primer comentario']);

        $response->assertJson([
            'data' => ['body' => 'Mi primer comentario']
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => 'Mi primer comentario'
        ]);
    }

    /**
     * @test
     */
    public function a_comment_required_a_body()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.comments.store',$status), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
