<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\IndexTaskResource;
use App\Http\Resources\Task\ShowTaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(
        private Task $taskModel
    ) {
    }

    public function index()
    {
        $data = $this->taskModel->paginate(env('PER_PAGE'));

        return IndexTaskResource::collection($data);
    }

    public function show(Task $task)
    {
        try {
            return ShowTaskResource::make($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();

            $task = $user->tasksCreated()
                ->create($request->validated());

            $taskLog = $task->taskLogs()->make([
                'description' => "Task {$task->name} created by {$user->name}",
            ]);

            $taskLogAction = $taskLog->taskLogAction()->firstWhere('slug', 'create');

            $taskLog->user()->associate($user);
            $taskLog->taskLogAction()->associate($taskLogAction);
            $taskLog->save();
            DB::commit();

            return ShowTaskResource::make($task);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();

            $task->update($request->validated());

            $taskLog = $task->taskLogs()->make([
                'description' => "Task {$task->name} updated by {$user->name}",
            ]);

            $taskLogAction = $taskLog->taskLogAction()->firstWhere('slug', 'update');

            $taskLog->user()->associate($user);
            $taskLog->taskLogAction()->associate($taskLogAction);
            $taskLog->save();
            DB::commit();

            return ShowTaskResource::make($task);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Task $task)
    {
        try {
            DB::beginTransaction();
            $user = request()->user();

            $task->delete();

            $taskLog = $task->taskLogs()->make([
                'description' => "Task {$task->name} deleted by {$user->name}",
            ]);

            $taskLogAction = $taskLog->taskLogAction()->firstWhere('slug', 'delete');

            $taskLog->user()->associate($user);
            $taskLog->taskLogAction()->associate($taskLogAction);
            $taskLog->save();
            DB::commit();

            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
