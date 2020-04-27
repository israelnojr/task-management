<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required | string | unique:projects'
        ]);

        $project = Project::create($data);
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required | string | unique:projects'
        ]);

        $project->update($data);
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return 'Delected Project';
    }
}
