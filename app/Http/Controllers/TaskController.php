<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }

    // Display all tasks for the authenticated user
    public function index() {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks.index', compact('tasks'));
    }

    // Show the task creation form
    public function create() {
        return view('tasks.create');
    }

    // Store a new task
    public function store(TaskRequest $request): RedirectResponse {
        $this->taskService->createTask($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // Show the form to edit an existing task
    public function edit(Task $task) {
        return view('tasks.edit', compact('task'));
    }

    // Update the task in the database
    public function update(TaskRequest $request, $taskId): RedirectResponse {
        $this->taskService->updateTask($taskId, $request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    // Toggle the status of a task
    public function toggleStatus($taskId): JsonResponse {
        try {
            $task = $this->taskService->toggleStatus($taskId);
            return response()->json(['status' => $task->status]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Delete a task
    public function destroy($taskId): RedirectResponse {
        $this->taskService->deleteTask($taskId);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
