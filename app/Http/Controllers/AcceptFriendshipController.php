<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\User;
use Illuminate\Http\Request;

class AcceptFriendshipController extends Controller
{
    public function index(Request $request)
    {
        return view('friendships.index',[
            'friendshipRequests' => $request->user()->friendshipRequestsReceived
        ]);
    }

    public function store(Request $request, User $sender)
    {
        $request->user()->acceptFriendRequestFrom($sender);

        return response()->json([
            'friendship_status' => 'accepted',
        ]);
    }

    public function destroy(Request $request, User $sender)
    {
        $request->user()->denyFriendRequestFrom($sender);

        return response()->json([
            'friendship_status' => 'denied',
        ]);
    }
}
