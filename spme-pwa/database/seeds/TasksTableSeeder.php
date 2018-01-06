<?php

use App\Task;
use App\Update;
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
        factory(Task::class, 300)->create()->each(function($task){
            for ($x = 0; $x <= rand(1, 5); $x++) { // Create some updates
                $task->updates()->save(factory(Update::class)->make());
            }
        });

        // Unassign some tasks
        Task::inRandomOrder()->take(50)->get()->each(function ($task) {
            $task->assigned_user = null;
            $task->save();
        });
    }
}
