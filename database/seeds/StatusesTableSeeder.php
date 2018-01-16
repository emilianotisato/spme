<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name' => 'working', 'label' => 'Encaminada', 'order' => 1, 'icon' => 'wb_sunny', 'color' => 'green']);
        Status::create(['name' => 'forgotten', 'label' => 'A la deriva', 'order' => 2, 'icon' => 'trending_down', 'color' => 'red']);
        Status::create(['name' => 'waiting_client', 'label' => 'Esperando al cliente', 'order' => 3, 'icon' => 'report_problem', 'color' => 'orange']);
        Status::create(['name' => 'stoped', 'label' => 'No avanzar!', 'order' => 4, 'icon' => 'report_problem', 'color' => 'orange']);
    }
}
