<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Models\Status;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Plot;

/**
 * Class TaskController
 * @package App\Http\Controllers\API
 */

class TaskAPIController extends AppBaseController
{
    /** @var  TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Task.
     * GET|HEAD /tasks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }


    //get tasks for a plot


    /**
     * Store a newly created Task in storage.
     * POST /tasks
     *
     * @param CreateTaskAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required|string',
            'task_date' => 'required|string',
            'plot_id' => 'required|integer',

        ];
        $request->validate($rules);

        $task = new Task();
        $task->name = $request->name;
        $task->task_date = $request->task_date;
        $task->plot_id = $request->plot_id;

        //get status
        $status = Status::where('name','Pending')->first();

        $status_id = Status::find(1);
        $task->status_id = $status_id->id;
        $task->save();
        $success['name'] = $task->name;
        $success['plot'] = $task->plot->name;
        $success['status'] = $task->status->name;
        $response = [
            'success'=>true,
            'data'=>$success,
            'message'=> 'taks  added successfully on the plot'
         ];

         return response()->json($response,201);


    }

    /**
     * Display the specified Task.
     * GET|HEAD /tasks/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully');
    }

    /**
     * Update the specified Task in storage.
     * PUT/PATCH /tasks/{id}
     *
     * @param int $id
     * @param UpdateTaskAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskAPIRequest $request)
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task = $this->taskRepository->update($input, $id);

        return $this->sendResponse($task->toArray(), 'Task updated successfully');
    }

    /**
     * Remove the specified Task from storage.
     * DELETE /tasks/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task->delete();

        return $this->sendSuccess('Task deleted successfully');
    }
}
