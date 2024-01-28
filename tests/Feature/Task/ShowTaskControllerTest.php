<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class ShowTaskControllerTest extends TestCase
{
    private string $prefix = '/api/task';

    private Task $task;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create(['created_by_id' => $this->user->id]);
    }

    public function test_show_route(): void
    {
        $response = $this->actingAs($this->user)->getJson("{$this->prefix}/{$this->task->id}");
        $response->assertStatus(200);
    }

    public function test_show_json_structure(): void
    {
        $response = $this->actingAs($this->user)->getJson("{$this->prefix}/{$this->task->id}");
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'createdBy' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ]);
    }

    public function test_show_resource_found(): void
    {
        $response = $this->actingAs($this->user)->getJson("{$this->prefix}/{$this->task->id}");
        $response->assertExactJson([
            'data' => [
                'id' => $this->task->id,
                'title' => $this->task->title,
                'description' => $this->task->description,
                'createdBy' => [
                    'id' => $this->task->createdBy->id,
                    'name' => $this->task->createdBy->name,
                    'email' => $this->task->createdBy->email,
                ],
            ],
        ]);
    }

    public function test_show_resource_not_found(): void
    {
        $this->task->delete();
        $response = $this->actingAs($this->user)->getJson("{$this->prefix}/{$this->task->id}");
        $response->assertStatus(404);
    }
}
