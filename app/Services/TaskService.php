<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getList($user_id) {
        return Task::where('created_by', $user_id)->get();
    }

    public function get(int $id): ?Task {
        return Task::findOrFail($id);
    }

    public function addNew($title, $description, $due_date, $created_by): ?Task {
        $data = [
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'created_by' => $created_by,
        ];

        $task = Task::create($data);

        if ($task && $task->id) {
            return $task;
        }

        return null;
    }

    public function modify($id, $params): int {
        return Task::where('id', $id)->update($params);
    }

    public function remove($id) {
        Task::where('id', $id)->delete();
    }
}