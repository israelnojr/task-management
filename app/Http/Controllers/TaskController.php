<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function index(Request $request, Project $project)
    {
        return Task::all();
        // return Task::where('projectId', 1)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required | string',
            'projectId' => 'required'
        ]);

        $priority = 1;
        $task = Task::create([ 
            'projectId' => $data['projectId'],
            'title' => $data['title'],
            'priority' => $priority
        ]);

        $priority++;
        return $task;
    
    }

  
    
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required | string',
        ]);
        $task->update($data);
        return $task;
    }

    
    public function destroy(Task $task)
    {
        $task->delete();
        return 'Delected Project';
    }
}
