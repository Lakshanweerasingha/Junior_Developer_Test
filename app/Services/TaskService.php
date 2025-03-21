<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService {
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository) {
        $this->taskRepository = $taskRepository;
    }


    public function getAllTasks(): LengthAwarePaginator {
        return $this->taskRepository->getAllTasks();
    }


    public function createTask(array $data): Task {
        return $this->taskRepository->storeTask($data);
    }


    public function updateTask(int $taskId, array $data): Task {
        return $this->taskRepository->updateTask($taskId, $data);
    }

 
    public function toggleStatus(int $taskId): Task {
        return $this->taskRepository->toggleTaskStatus($taskId);
    }

 
    public function deleteTask(int $taskId): bool {
        // Log the deletion action in the AuditLog table
        $task = $this->taskRepository->getTaskById($taskId);
        AuditLog::create([
            'action' => 'deleted',
            'model' => 'Task',
            'model_id' => $task->id,
            'user_name' => Auth::user()->name,
            'action_time' => now(),
        ]);

        return $this->taskRepository->deleteTask($taskId);
    }
}
