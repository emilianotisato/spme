<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use App\Update;

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

    /**
     * Create a new coment/upate for the task
     *
     * @param UpdateRequest $request
     * @return void
     */
    public function postTaskUpdate(UpdateRequest $request)
    {
        Auth::user()->updates()->create($request->all());

        $task = Task::findOrFail($request->get('task_id'));

        if ($request->get('closed')) {
            $task->closeTask();
        }

        return $task;
    }

    public function deleteTaskUpdate(Request $request)
    {
        $update = Update::findOrFail($request->get('id'));
        $update->delete();

        return Task::findOrFail($request->get('task_id'));
    }
}
