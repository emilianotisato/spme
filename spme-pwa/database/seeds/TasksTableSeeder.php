<?php

use App\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class, 300)->create();

        Task::inRandomOrder()->take(50)->get()->each(function ($task) {
            $task->assigned_user = null;
            $task->save();
        });
    }
}
