<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\Task\IndexTaskResource;
use App\Http\Resources\Task\ShowTaskResource;
use App\Models\Task;
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
        return ShowTaskResource::make($task);
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $task = $request->user()
                ->tasks()
                ->create($request->validated());
            DB::commit();

            return ShowTaskResource::make($task);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
