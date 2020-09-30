<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskChangeStatusRequest;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\BaseResource;
use App\Task;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $tasksQuery = Task::query()->with(['creator', 'executor']);
        $status     = $request->get('status');
        if (in_array($status, Task::STATUS_VALUES)) {
            $tasksQuery->where('status', $status);
        }

        return BaseResource::collection($tasksQuery->get());
    }

    /**
     * @param TaskCreateRequest $request
     *
     * @return BaseResource
     */
    public function store(TaskCreateRequest $request)
    {
        $validatedData               = $request->validated();
        $validatedData['status']     = Task::STATUS_NEW;
        $validatedData['creator_id'] = $request->user()->id;
        $newTask                     = Task::query()->create($validatedData);

        return BaseResource::make($newTask);
    }

    /**
     * @param TaskUpdateRequest $request
     * @param Task $task
     *
     * @return BaseResource|Response
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $validatedData = $request->validated();

        if ($task->status !== $task::STATUS_NEW) {
            return response('only new tasks are allowed to be updated', Response::HTTP_FORBIDDEN);
        }

        if (!$task->update($validatedData)) {
            return response('could not update resource', Response::HTTP_BAD_REQUEST);
        }

        return BaseResource::make($task);
    }

    /**
     * @param TaskChangeStatusRequest $request
     * @param Task $task
     *
     * @return BaseResource|Response
     */
    public function changeStatus(TaskChangeStatusRequest $request, Task $task)
    {
        $validatedData = $request->validated();

        if (empty($task->executor_id)) {
            $validatedData['executor_id'] = $request->user()->id;
        }

        if (!$task->update($validatedData)) {
            return response('could not update resource', Response::HTTP_BAD_REQUEST);
        }

        return BaseResource::make($task);
    }

    /**
     * @param Task $task
     *
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Task $task)
    {
        if ($task->status !== $task::STATUS_NEW) {
            return response('only new tasks are allowed to be deleted', Response::HTTP_FORBIDDEN);
        } elseif ($task->delete()) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response('could not delete resource', Response::HTTP_RESET_CONTENT);
        }
    }
}
