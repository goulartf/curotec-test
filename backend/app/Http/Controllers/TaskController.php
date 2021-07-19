<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{

    public function index()
    {
        return TaskResource::collection(Task::all());
    }

    public function store(Request $request){

        return new TaskResource(Task::create($request->only('title')));
    }

    public function update(Request $request, Task $task){

        $task->update($request->only('completed'));

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response('', 204);
    }
}
