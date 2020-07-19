<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Http\Resources\StatusResource;
use App\Status;
use App\Events\StatusCreated;

class StatusController extends Controller
{
    public function index()
    {
        return StatusResource::collection(Status::latest()->paginate());
    }

    public function show(Status $status)
    {
        return view('statuses.show', [
            'status' => StatusResource::make($status)
        ]);
    }

    public function store(StatusRequest $request)
    {
        $status = $request->user()->statuses()->create([
            'body' => $request->body,
        ]);

        $statusResource = StatusResource::make($status);
        StatusCreated::dispatch($statusResource);

        return $statusResource;
    }
}
