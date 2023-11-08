<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getList() {
        return Task::all();
    }

    public function get(int $id): ?Task {
        return Task::findOrFail($id);
    }

    public function addNew($title, $description, $due_date, $created_by, $assignee_id): ?Task {
        $data = [
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'created_by' => $created_by,
            'assignee_id' => $assignee_id,
        ];

        $task = Task::create($data);

        if ($task && $task->id) {
            return $task;
        }

        return null;
    }

    public function modify(Task $task, $title, $description, $due_date, $assignee_id, $status) {
        $data = [
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'assignee_id' => $assignee_id,
            'status' => $status,
        ];

        $task->update($data);
    }

    public function remove($id) {
        Task::where('id', $id)->delete();
    }
}