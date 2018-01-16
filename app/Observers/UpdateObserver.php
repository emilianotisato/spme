<?php

namespace App\Observers;

use App\Task;
use App\Update;

class UpdateObserver
{
    /**
     * Listen to the Update saved event.
     *
     * @param  \App\Update  $update
     * @return void
     */
    public function saved(Update $update)
    {
        $task = Task::findOrFail($update->task_id);
        $task->updated_at = $update->updated_at;
        $task->save();
    }

    /**
     * Listen to the Update deleted event.
     *
     * @param  \App\Update  $update
     * @return void
     */
    public function deleted(Update $update)
    {
        //
    }
}