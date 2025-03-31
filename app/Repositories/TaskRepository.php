<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository {

    public function getAllTasks(): LengthAwarePaginator {
        return Auth::check() ? Auth::user()->tasks()->paginate(5) : new LengthAwarePaginator([], 0, 10);
    }

 
    public function storeTask(array $data): Task {
        if (Auth::check()) {
            return Auth::user()->tasks()->create($data);
        }

        throw new \Exception('User not authenticated');
    }

 
    public function updateTask(int $taskId, array $data): Task {
        $task = Auth::user()->tasks()->find($taskId);

        if ($task) {
            $task->update($data);
            return $task;
        }

        throw new \Exception('Task not found or does not belong to authenticated user');
    }

     

    public function getTaskById(int $taskId): Task {
        return Task::findOrFail($taskId);
    }

   
    public function toggleTaskStatus(int $taskId): Task {
        $task = Auth::user()->tasks()->find($taskId);

        if (!$task) {
            throw new \Exception('Task not found or does not belong to authenticated user');
        }

        // Prevent changing status of completed tasks past the due date
        if ($task->status == 'Completed' && now()->gt($task->due_date)) {
            throw new \Exception('You cannot change the status of completed tasks past the due date.');
        }

        $task->status = $task->status == 'Completed' ? 'Pending' : 'Completed';
        $task->save();

        return $task;
    }

  
    public function deleteTask(int $taskId): bool {
        $task = Auth::user()->tasks()->find($taskId);

        if ($task) {
            return $task->delete();
        }

        throw new \Exception('Task not found or does not belong to authenticated user');
    }
}
