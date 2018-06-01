<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaLibraryRequest;

class MediaLibraryController extends Controller
{
    public function taskStore(MediaLibraryRequest $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $mediaObject = $task->addMedia($request->file('file'))->toMediaCollection($task->project_id);

        return $mediaObject->toJson();
    }
}
