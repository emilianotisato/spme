<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create(['name' => 'Baja', 'level' => 1]);
        Priority::create(['name' => 'Media', 'level' => 5]);
        Priority::create(['name' => 'Alta!', 'level' => 10]);
    }
}
