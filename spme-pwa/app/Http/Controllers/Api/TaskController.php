<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function getTasks()
    {
        return Task::all();
    }

    public function editTaskField($id, TaskRequest $request)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task->fresh();
    }
}
