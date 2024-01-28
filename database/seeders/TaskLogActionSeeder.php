<?php

namespace Database\Seeders;

use App\Models\TaskLogAction;
use Illuminate\Database\Seeder;

class TaskLogActionSeeder extends Seeder
{
    public function run(): void
    {
        TaskLogAction::factory()->createMany([
            [
                'action' => 'Create',
                'slug' => 'create',
            ],
            [
                'action' => 'Update',
                'slug' => 'update',
            ],

        ]);
    }
}
