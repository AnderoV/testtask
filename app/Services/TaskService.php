<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskService
{
    
     // tagastab kõik kasutaja ülesanded 
    public function all()
    {
        return Auth::user()->tasks ?? collect();
    }

    public function create(array $data): Task
    {
        $data['uuid'] = $data['uuid'] ?? (string) Str::uuid();
        return Auth::user()->tasks()->create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
