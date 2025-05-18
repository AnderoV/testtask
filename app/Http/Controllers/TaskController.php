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
        $tasks = $this->taskService->all();
        return response()->json([
            'ülesanded' => $tasks,
            'kogus' => $tasks->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,in_progress,done',
        ]);

        $task = $this->taskService->create($validated);
        return response()->json([
            'sõnum' => 'Ülesanne loodud',
            'ülesanne' => $task
        ], 201);
    }

    public function show($uuid)
    {
    $task = Task::where('uuid', $uuid)->firstOrFail();
    return response()->json([
        'ülesanne' => $task
    ]);
    }

    public function update(Request $request, $uuid)
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,done',
        ]);
        $this->taskService->update($task, $validated);

        Log::info('Ülesanne uuendatud: ' . $task->uuid, [ 'muudetud_andmed' => $validated]);
        return response()->json([
            'sõnum' => 'Ülesanne uuendatud',
            'ülesanne' => $task
        ]);
    }

    public function destroy($uuid)
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();
        $this->taskService->delete($task);

        Log::info('Ülesanne kustutatud: ' . $task->uuid);
        return response()->json([
            'sõnum' => 'Ülesanne kustutatud'
        ]);
    }

    public function upload(Request $request, $uuid)
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();

        Log::info('Upload funkab');
        \Log::info('UPLOAD ALGAS');
        \Log::info('User: ' . optional(auth()->user())->email);
        \Log::info('Task UUID: ' . $task->uuid);
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
