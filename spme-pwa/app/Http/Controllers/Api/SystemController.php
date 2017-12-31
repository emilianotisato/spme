<?php

namespace App\Http\Controllers\Api;

use App\Status;
use App\Priority;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function getStatuses()
    {
        return Status::all();
    }

    public function getPriorities()
    {
        return Priority::all();
    }
}
