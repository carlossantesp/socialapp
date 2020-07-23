<?php

namespace Tests\Unit\Notifications;

// use PHPUnit\Framework\TestCase;

use App\Comment;
use App\Notifications\NewCommentNotification;
use App\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewCommentNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_notification_is_stored_in_the_database()
    {
        $status = factory(Status::class)->create();

        $comment = factory(Comment::class)->create([
            'status_id' => $status->id
        ]);

        $statusOwner = $status->user;

        $statusOwner->notify(new NewCommentNotification($comment));

        $this->assertCount(1, $statusOwner->notifications);

        $notificationData = $statusOwner->notifications->first()->data;

        $this->assertEquals($comment->path(), $notificationData['link']);

        $this->assertEquals("{$comment->user->name} commento tu publicacion", $notificationData['message']);
    }
}
