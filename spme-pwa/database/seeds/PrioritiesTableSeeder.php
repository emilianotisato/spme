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
        Priority::create(['label' => 'Baja', 'level' => 1]);
        Priority::create(['label' => 'Media', 'level' => 5]);
        Priority::create(['label' => 'Alta!', 'level' => 10]);
    }
}
