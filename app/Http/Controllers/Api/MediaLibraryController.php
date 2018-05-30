<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaLibraryController extends Controller
{
    public function taskStore($taskId)
    {
        $task = Task::findOrFail($taskId);

        return 'holis';
        return $task;
    }
}
