<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Task;
use App\Update;
use Illuminate\Http\Request;
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
        return Task::opened()->get();
    }

    /**
     * Create full task
     *
     * @param TaskRequest $request
     * @return void
     */
    public function postTask(TaskRequest $request)
    {
        $task = Auth::user()->openTasks()->create($request->all());
        return $task->fresh();
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
        if (! Auth::user()->can('task_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task->fresh();
    }

    /**
     * Delete task
     *
     * @param Request $request
     * @return void
     */
    public function deleteTask($id)
    {
        if (! Auth::user()->can('task_delete')) {
            abort(403, 'Unauthorized action.');
        }

        return Task::destroy($id);
    }

    /**
     * Create a new coment/upate for the task
     * Also if 'closed" attribute is in the request, close the asociated task
     *
     * @param UpdateRequest $request
     * @return void
     */
    public function postTaskUpdate(UpdateRequest $request)
    {
        Auth::user()->updates()->create($request->all());

        $task = Task::findOrFail($request->get('task_id'));

        if ($request->get('closed')) {
            if (! Auth::user()->can('task_close')) {
                abort(403, 'Unauthorized action.');
            }
            $task->closeTask();
        }

        return $task->fresh();
    }

    /**
     * Delete update on task only if is owner of the update
     *
     * @param Request $request
     * @return void
     */
    public function deleteTaskUpdate(Request $request)
    {
        if (Auth::user()->id !== $request->get('user_id')) {
            abort(403, 'Unauthorized action.');
        }

        Update::destroy($request->get('id'));

        return Task::findOrFail($request->get('task_id'));
    }
}
