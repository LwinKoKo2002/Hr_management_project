<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $task = new Task();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->dead_line = $request->dead_line;
        $task->status_id = $request->status_id;
        $task->priority_id = $request->priority_id;
        $task->save();

        $task->members()->sync($request->members);

        return 'success';
    }

    public function taskData(Request $request)
    {
        $project = Project::with('tasks')->firstWhere('id', $request->project_id);
        return view('components.task', compact('project'))->render();
    }



    public function update(Request $request, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->dead_line = $request->dead_line;
        $task->priority_id = $request->priority_id;
        $task->update();

        $task->members()->sync($request->members);

        return 'success';
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return 'success';
    }
}
