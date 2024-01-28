<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskLogAction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'task_log_action_id' => TaskLogAction::inRandomOrder()->first()->id,
            'task_id' => Task::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
