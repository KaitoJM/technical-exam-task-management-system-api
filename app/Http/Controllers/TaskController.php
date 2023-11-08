<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Http\Requests\AddNewTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use App\Http\Resources\TaskResource;

use App\Services\TaskService;

class TaskController extends Controller
{
    private TaskService $task_service;

    public function __construct() {
        $this->task_service = new TaskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->task_service->getList();

        return response(TaskResource::collection($list));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewTaskRequest $request)
    {
        $task = $this->task_service->addNew(
            $request->title,
            $request->description,
            $request->due_date,
            Auth::user()->id,
        );

        if ($task->id) {
            Log::info(Auth::user()->name . ' has created a new task with title "' . $request->title . '".');
            return response()->json(new TaskResource($task), 201);
        }

        Log::error('There was an error while adding a new task user with title "' . $request->title . '".');
        return response()->json('Something wen\'t wrong with your request. Please try again.', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->task_service->get($id);

        return response(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $updated = $this->task_service->modify(
            $id,
            $request->all(),
        );

        if ($updated) {
            Log::info(Auth::user()->name . ' updated a task with  id #' . $id . '.');
            return response()->json($updated);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
