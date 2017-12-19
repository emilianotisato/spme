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
        Status::create(['name' => 'working', 'label' => 'Encaminada', 'order' => 1]);
        Status::create(['name' => 'forgotten', 'label' => 'A la deriva', 'order' => 2]);
        Status::create(['name' => 'waiting_client', 'label' => 'Esperando al cliente', 'order' => 3]);
        Status::create(['name' => 'stoped', 'label' => 'No avanzar!', 'order' => 4]);
    }
}
