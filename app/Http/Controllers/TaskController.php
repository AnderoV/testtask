<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    private TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return response()->json([
            'ülesanded' => $this->taskService->all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $this->taskService->create($validated);
        return response()->json([
            'sõnum' => 'Ülesanne loodud',
            'ülesanne' => $task
        ], 201);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->taskService->update($task, $validated);
        return response()->json([
            'sõnum' => 'Ülesanne uuendatud',
            'ülesanne' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $this->taskService->delete($task);
        return response()->json([
            'sõnum' => 'Ülesanne kustutatud'
        ]);
    }

    public function upload(Request $request, Task $task)
{
    Log::info('Upload funkab');
    \Log::info('UPLOAD ALGAS');
    \Log::info('User: ' . optional(auth()->user())->email);
    \Log::info('Task ID: ' . $task->id);
    \Log::info('Has file: ' . json_encode($request->hasFile('file')));

    $request->validate([
        'file' => 'required|file|max:2048',
    ]);

    $filename = time() . '_' . $request->file('file')->getClientOriginalName();
    $path = $request->file('file')->storeAs('tasks', $filename, 'public');
    $task->update(['file_path' => $path]);

    return response()->json([
        'sõnum' => 'Fail laaditud',
        'failitee' => $path,
        'link' => asset('storage/' . $path)
    ]);
}
}
