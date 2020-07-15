<?php

namespace Tests\Feature;

use App\Comment;
use App\Status;
use App\User;
use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
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
    public function an_event_is_fired_when_a_comment_is_created()
    {
        Event::fake([CommentCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->postJson(route('statuses.comments.store',$status), ['body' => 'Mi primer comentario']);

        Event::assertDispatched(CommentCreated::class, function($commentCreatedEvent) {
            $this->assertInstanceOf(ShouldBroadcast::class,$commentCreatedEvent);
            $this->assertInstanceOf(CommentResource::class,$commentCreatedEvent->comment);
            $this->assertInstanceOf(Comment::class,$commentCreatedEvent->comment->resource);
            $this->assertEquals(Comment::first()->id, $commentCreatedEvent->comment->id);
            $this->assertEquals('socket-id', $commentCreatedEvent->socket, 'The event '. get_class($commentCreatedEvent) . ' must call the method "dontBroadcastToCurrentUser" in the constructor.');

            return true;
        });
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
