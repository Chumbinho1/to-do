<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'completed_at' => 2 % rand(1, 100) === 0 ? $this->faker->dateTime() : null,
            'created_by_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
