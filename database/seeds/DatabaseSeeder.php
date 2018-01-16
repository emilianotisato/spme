<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);

        if (App::isLocal()) {
            $this->call(ProjectsTableSeeder::class);
            $this->call(TasksTableSeeder::class);
        }
    }
}
