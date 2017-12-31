<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function getTasks()
    {
        return Task::all();
    }
}
