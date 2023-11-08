<?php

namespace App\Services;

use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskService
{
    public function getList() {
        return TaskResource::collection(Task::all());
    }
}