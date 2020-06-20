<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusLikeController extends Controller
{
    public function store(Status $status)
    {
        $status->like();
    }

    public function destroy(Status $status)
    {
        $status->unlike();
    }
}
