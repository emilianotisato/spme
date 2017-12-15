<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::isLocal()) {
            User::create(['name' => 'Emiliano', 'email' => 'info@thormaweb.com', 'password' => Hash::make('123')]);
        }
    }
}
