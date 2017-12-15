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
        $this->call(SeveritiesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);

        if (App::isLocal()) {
            $this->call(ClientsTableSeeder::class);
            $this->call(ProjectsTableSeeder::class);
            $this->call(TicketTableSeeder::class);
        }
    }
}
