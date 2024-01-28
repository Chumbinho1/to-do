<?php

namespace Tests\Feature\Task;

use App\Models\TaskLog;
use App\Models\User;
use Tests\TestCase;

class StoreTaskControllerTest extends TestCase
{
    private string $prefix = '/api/task';

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_store_task_route(): void
    {
        $data = $this->initData();
        $response = $this->actingAs($this->user)->postJson("{$this->prefix}", $data);
        $response->assertStatus(201);
    }

    public function test_store_task_route_unauthenticated(): void
    {
        $data = $this->initData();
        $response = $this->postJson("{$this->prefix}", $data);
        $response->assertStatus(401);
    }

    public function test_store_task_route_without_title(): void
    {
        $data = $this->initData();
        unset($data['title']);
        $response = $this->actingAs($this->user)->postJson("{$this->prefix}", $data);
        $response->assertStatus(422);
    }

    public function test_store_task_route_without_description(): void
    {
        $data = $this->initData();
        unset($data['description']);
        $response = $this->actingAs($this->user)->postJson("{$this->prefix}", $data);
        $response->assertStatus(201);
    }

    public function test_store_task_route_log_has_been_created(): void
    {
        $data = $this->initData();
        $this->actingAs($this->user)->postJson("{$this->prefix}", $data);
        $taskLogs = TaskLog::all();
        $this->assertCount(1, $taskLogs);
    }

    private function initData()
    {
        return [
            'title' => 'Test Title',
            'description' => 'Test Description',
        ];
    }
}
