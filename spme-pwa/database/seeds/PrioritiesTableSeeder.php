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
        Priority::create(['name' => 'Alta!', 'level' => 10]);
        Priority::create(['name' => 'Media', 'level' => 50]);
        Priority::create(['name' => 'Baja', 'level' => 100]);
    }
}
