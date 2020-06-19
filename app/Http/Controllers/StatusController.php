<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Status;

class StatusController extends Controller
{
    public function index()
    {
        return Status::latest()->paginate();
    }
    public function store(StatusRequest $request)
    {
        $status = Status::create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['body' => $status->body]);
    }
}
