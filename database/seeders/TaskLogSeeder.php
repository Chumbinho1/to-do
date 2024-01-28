<?php

namespace Database\Seeders;

use App\Models\TaskLog;
use Illuminate\Database\Seeder;

class TaskLogSeeder extends Seeder
{
    public function run(): void
    {
        TaskLog::factory(30)->create();
    }
}
