<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class ReadNotificationController extends Controller
{
    public function store(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return $notification;
    }

    public function destroy(DatabaseNotification $notification)
    {
        $notification->markAsUnread();

        return $notification;
    }
}
