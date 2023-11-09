<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getList($user_id, $filters = null) {
        $query = Task::where('created_by', $user_id)
            ->orderBy('created_at', 'DESC');

        if (isset($filters['search'])) {
            $query->where(function($search) use ($filters) {
                $search->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['status']) && ($filters['status'] != 'all')) {
            $query->where('status', $filters['status']);
        }

        $data = $query->get();

        return $data;
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
            'status' => 'open'
        ];

        $task = Task::create($data);

        if ($task && $task->id) {
            return $task;
        }

        return null;
    }

    public function modify($id, $params): ?Task {
        // remove unecessary parameters
        unset($params['created_at']);
        unset($params['updated_at']);

        $updated = Task::where('id', $id)->update($params);

        if ($updated) {
            return Task::find($id);
        }
        
        return null;
    }

    public function remove($id): ?int {
        return Task::where('id', $id)->delete();
    }
}