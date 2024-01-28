<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use Tests\TestCase;

class UpdateTaskControllerTest extends TestCase
{
    private string $prefix = '/api/task';

    private User $user;

    private Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function test_update_task_route(): void
    {
        $data = $this->initData();
        $response = $this->actingAs($this->user)->putJson("{$this->prefix}/{$this->task->id}", $data);
        $response->assertStatus(200);
    }

    public function test_update_task_route_unauthenticated(): void
    {
        $data = $this->initData();
        $response = $this->putJson("{$this->prefix}/{$this->task->id}", $data);
        $response->assertStatus(401);
    }

    public function test_update_task_route_without_title(): void
    {
        $data = $this->initData();
        unset($data['title']);
        $response = $this->actingAs($this->user)->putJson("{$this->prefix}/{$this->task->id}", $data);
        $response->assertStatus(422);
    }

    public function test_update_task_route_without_description(): void
    {
        $data = $this->initData();
        unset($data['description']);
        $response = $this->actingAs($this->user)->putJson("{$this->prefix}/{$this->task->id}", $data);
        $response->assertStatus(200);
    }

    public function test_update_task_route_log_has_been_created(): void
    {
        $data = $this->initData();
        $this->actingAs($this->user)->putJson("{$this->prefix}/{$this->task->id}", $data);
        $taskLogs = TaskLog::all();
        $this->assertCount(1, $taskLogs);
    }

    public function test_update_task_route_with_invalid_task_id(): void
    {
        $data = $this->initData();
        $this->task->delete();
        $response = $this->actingAs($this->user)->putJson("{$this->prefix}/{$this->task->id}", $data);
        $response->assertStatus(404);
    }

    private function initData()
    {
        return [
            'title' => 'Test Title',
            'description' => 'Test Description',
        ];
    }
}
