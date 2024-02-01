<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use Tests\TestCase;

class DestroyTaskControllerTest extends TestCase
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

    public function test_destroy_task_route(): void
    {
        $response = $this->actingAs($this->user)->deleteJson("{$this->prefix}/{$this->task->id}");
        $response->assertStatus(204);
        $this->assertCount(0, Task::all());
    }

    public function test_destroy_task_route_unauthenticated(): void
    {
        $response = $this->deleteJson("{$this->prefix}/{$this->task->id}");
        $response->assertStatus(401);
    }

    public function test_destroy_task_route_log_has_been_created(): void
    {
        $this->actingAs($this->user)->deleteJson("{$this->prefix}/{$this->task->id}");
        $this->assertCount(1, TaskLog::all());
    }

    public function test_destroy_task_route_with_invalid_task_id(): void
    {
        $response = $this->actingAs($this->user)->deleteJson("{$this->prefix}/0");
        $response->assertStatus(404);
    }
}
