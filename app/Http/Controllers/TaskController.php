<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function getTaskByProject(Request $request, Project $project)
    {
        return Task::where('projectId', $project->id)->get();
    }

    public function index()
    {
        return Task::orderBy('priority', 'ASC')->get();
    }


    public function store(Request $request)
    {
        $tasks = Task::all();
        $priority = 0 ;
        
        $count = $tasks->count();
        while($priority <= $count){
            $priority++;
        }

        $data = $request->validate([
            'title' => 'required | string',
            'projectId' => 'required'
        ]);
        $task = Task::create([ 
            'projectId' => $data['projectId'],
            'title' => $data['title'],
            'priority' => $priority
        ]);

        $priority++;
        return $task;
    
    }

    public function updatePriority(Request $request){
        $tasks = Task::all();
        foreach($tasks as $task){
            $id = $task->id;
            foreach($request->tasks as $reqTask){
                if($reqTask['id'] == $id){
                    $task->update(['priority' => $reqTask['priority']]);
                }
            }
        }
         
        return 'updated successfully';
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
