<?php

namespace App;

use App\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'projectId',
        'title',
        'priority'
    ];

    public function project()
    {
        $this->belongsTo(App::Project, 'projectId');
    }
}
