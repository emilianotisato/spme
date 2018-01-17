<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        // Permissions
        $client_create = Permission::create(['name' => 'client_create']);
        $client_edit = Permission::create(['name' => 'client_edit']);
        $client_deactivate = Permission::create(['name' => 'client_deactivate']);
        $client_delete = Permission::create(['name' => 'client_delete']);
        $client_see_secret = Permission::create(['name' => 'client_see_secret']);
        $client_add_notes = Permission::create(['name' => 'client_add_notes']);
        $project_create = Permission::create(['name' => 'project_create']);
        $project_edit = Permission::create(['name' => 'project_edit']);
        $project_delete = Permission::create(['name' => 'project_delete']);
        $task_create = Permission::create(['name' => 'task_create']);
        $task_edit = Permission::create(['name' => 'task_edit']);
        $task_close = Permission::create(['name' => 'task_close']);
        $task_delete = Permission::create(['name' => 'task_delete']);

        // Admin
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($client_create);
        $admin->givePermissionTo($client_edit);
        $admin->givePermissionTo($client_deactivate);
        $admin->givePermissionTo($client_delete);
        $admin->givePermissionTo($client_see_secret);
        $admin->givePermissionTo($client_add_notes);
        $admin->givePermissionTo($project_create);
        $admin->givePermissionTo($project_edit);
        $admin->givePermissionTo($project_delete);
        $admin->givePermissionTo($task_create);
        $admin->givePermissionTo($task_edit);
        $admin->givePermissionTo($task_close);
        $admin->givePermissionTo($task_delete);

        // Manager
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo($client_deactivate);
        $manager->givePermissionTo($client_see_secret);
        $manager->givePermissionTo($client_add_notes);
        $manager->givePermissionTo($project_create);
        $manager->givePermissionTo($project_edit);
        $manager->givePermissionTo($task_create);
        $manager->givePermissionTo($task_edit);
        $manager->givePermissionTo($task_close);
        $manager->givePermissionTo($task_delete);

        // Staff
        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo($task_create);
        $staff->givePermissionTo($task_edit);
        $staff->givePermissionTo($task_close);

        // Client
        $client = Role::create(['name' => 'client']);

        // Freelance
        $freelance = Role::create(['name' => 'freelance']);
        $freelance->givePermissionTo($task_close);

        /**
         * Set aplication admin user
         */
        $admin = User::create(['name' => 'Emiliano', 'email' => 'info@thormaweb.com', 'password' => Hash::make('Nf1959')]);
        $admin->assignRole('admin');

        if (App::isLocal()) {
            $manager = User::create(['name' => 'manager', 'email' => 'manager@thormaweb.com', 'password' => Hash::make('123456')]);
            $manager->assignRole('manager');
            // Create staff
            factory(User::class, 2)->create()->each(function ($user) {
                $user->assignRole('manager');
            });

            $staff = User::create(['name' => 'staff', 'email' => 'staff@thormaweb.com', 'password' => Hash::make('123456')]);
            $staff->assignRole('staff');
            factory(User::class, 10)->create()->each(function ($user) {
                $user->assignRole('staff');
            });

            $freelance = User::create(['name' => 'freelance', 'email' => 'freelance@thormaweb.com', 'password' => Hash::make('123456')]);
            $freelance->assignRole('freelance');
            factory(User::class, 25)->create()->each(function ($user) {
                $user->assignRole('freelance');
            });

            $client = User::create(['name' => 'client', 'email' => 'client@thormaweb.com', 'password' => Hash::make('123456')]);
            $client->assignRole('client');
            // Create some clients
            factory(App\Client::class, 50)->create()->each(function ($client) {
                $user = factory(User::class)->make();
                $this->convertToClient($user, $client);

                if (rand(0, 1) == 0) { // Some clients has more than one user
                    factory(User::class, rand(1, 3))->create()->each(function ($user) use ($client) {
                        $this->convertToClient($user, $client);
                    });
                }
            });
        }
    }

    private function convertToClient($user, $client)
    {
        $user->client_id = $client->id;
        $user->save();
        $user->assignRole('client');
    }
}
