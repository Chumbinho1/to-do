<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskLogActionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'action' => $this->faker->unique()->word,
            'slug' => $this->faker->unique()->slug,
        ];
    }
}
