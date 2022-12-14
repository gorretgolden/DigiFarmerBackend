<?php

namespace App\Http\Controllers;

use App\DataTables\TaskDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\TaskRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends AppBaseController
{
    /** @var TaskRepository $taskRepository*/
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Task.
     *
     * @param TaskDataTable $taskDataTable
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = Task::latest()->paginate(6);

        return view('tasks.index')
            ->with('tasks', $tasks);
    }


    public function taskCalender(Request $request)

    {
        $tasks = \App\Models\Task::all();
        return view('tasks.calender')->with('tasks',$tasks);
    }

    /**
     * Show the form for creating a new Task.
     *
     * @return Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param CreateTaskRequest $request
     *
     * @return Response
     */
    public function store(CreateTaskRequest $request)
    {
        $input = $request->all();
        $input['status_id'] = $request->status_id;
        //dd($input['status_id']);

        $existing_name = Task::where('name',$request->name)->first();
        $existing_plot = Task::where('plot_id',$request->plot_id)->first();

        if($existing_name && $existing_plot){
            Flash::error('Task already exists on the plot');

            return redirect(route('tasks.index'));

        }
        else{

            $task = $this->taskRepository->create($input);

            Flash::success('Task saved successfully.');

            return redirect(route('tasks.index'));
        }


    }

    /**
     * Display the specified Task.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified Task.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.edit')->with('task', $task);
    }

    /**
     * Update the specified Task in storage.
     *
     * @param int $id
     * @param UpdateTaskRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $task = $this->taskRepository->update($request->all(), $id);

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $this->taskRepository->delete($id);

        Flash::success('Task deleted successfully.');

        return redirect(route('tasks.index'));
    }
}
