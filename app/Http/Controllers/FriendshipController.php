<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function store(User $recipient)
    {
        if(auth()->id() === $recipient->id)
        {
            abort(400);
        }
        $friendship = Friendship::firstOrCreate([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id,
        ]);

        return response()->json([
            'friendship_status' => $friendship->fresh()->status
        ]);
    }

    public function destroy(User $user)
    {
        $friendship = Friendship::betweenUsers(auth()->user(),$user)->first();

        if($friendship->status === 'denied' && (int)$friendship->sender_id === auth()->id())
        {
            return response()->json([
                'friendship_status' => 'denied'
            ]);
        }

        return response()->json([
            'friendship_status' => $friendship->delete() ? 'deleted' : ''
        ]);
    }
}
