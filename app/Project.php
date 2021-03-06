<?php

namespace App;

use App\Task;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    protected $fillable = [
        'title'
    ];

    public function tasks()
    {
        $this->hasMany(App::Task);
    }
}
