<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    
     // tagastab kõik kasutaja ülesanded 
    public function all()
    {
        return Auth::user()->tasks;
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();

        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        return $task->update($data);
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}
