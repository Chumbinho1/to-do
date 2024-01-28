<?php

namespace Tests\Feature\Task;

use App\Models\User;
use Tests\TestCase;

class IndexTaskControllerTest extends TestCase
{
    private string $prefix = '/api/task';

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->user = User::whereHas('tasksCreated')->first();
    }

    public function test_index_route()
    {
        $response = $this->actingAs($this->user)->getJson($this->prefix);
        $response->assertStatus(200);
    }

    public function test_index_route_unauthenticated()
    {
        $response = $this->getJson($this->prefix);
        $response->assertStatus(401);
    }

    public function test_index_resource_structure()
    {
        $response = $this->actingAs($this->user)->getJson($this->prefix);
        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                    ],
                ],
            ]
        );
    }
}
