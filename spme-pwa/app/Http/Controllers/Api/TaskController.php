<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;

class TaskController extends Controller
{
    /**
     * Get task Collection
     *
     * @return void
     */
    public function getTasks()
    {
        return Task::all();
    }

    /**
     * Edit individual task fields
     *
     * @param [type] $id
     * @param TaskRequest $request
     * @return void
     */
    public function editTaskField($id, TaskRequest $request)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task->fresh();
    }

    public function postTaskUpdate(UpdateRequest $request)
    {
        Auth::user()->updates()->create($request->all());

        $task = Task::findOrFail($request->get('task_id'));

        if ($request->get('closed')) {
            $task->closeTask();
        }

        return $task;
    }
}
