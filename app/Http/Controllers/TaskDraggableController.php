<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class TaskDraggableController extends Controller
{
    public function taskData(Request $request)
    {
        $project = Project::with('tasks')->firstWhere('id', $request->project_id);
        if ($request->pendingTaskItem) {
            $items = explode(',', $request->pendingTaskItem);
            foreach ($items as $key => $task_id) {
                $task = collect($project->tasks)->firstWhere('id', $task_id);
                if ($task) {
                    $task->serial_number = $key;
                    $task->status_id = 1;
                    $task->save();
                }
            }
        }

        if ($request->inprogressTaskItem) {
            $items = explode(',', $request->inprogressTaskItem);
            foreach ($items as $key => $task_id) {
                $task = collect($project->tasks)->firstWhere('id', $task_id);
                if ($task) {
                    $task->serial_number = $key;
                    $task->status_id = 2;
                    $task->save();
                }
            }
        }

        if ($request->completeTaskItem) {
            $items = explode(',', $request->completeTaskItem);
            foreach ($items as $key => $task_id) {
                $task = collect($project->tasks)->firstWhere('id', $task_id);
                if ($task) {
                    $task->serial_number = $key;
                    $task->status_id = 3;
                    $task->save();
                }
            }
        }

        return 'success';
    }
}
