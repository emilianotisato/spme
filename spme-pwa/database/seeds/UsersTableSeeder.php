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
        $manage_clients = Permission::create(['name' => 'manage_clients']);
        $manage_projects = Permission::create(['name' => 'manage_projects']);
        $create_tasks = Permission::create(['name' => 'create_tasks']);
        $edit_tasks = Permission::create(['name' => 'edit_tasks']);
        $close_tasks = Permission::create(['name' => 'close_tasks']);
        $delete_tasks = Permission::create(['name' => 'delete_tasks']);

        // Admin
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($manage_clients);
        $admin->givePermissionTo($manage_projects);
        $admin->givePermissionTo($create_tasks);
        $admin->givePermissionTo($edit_tasks);
        $admin->givePermissionTo($close_tasks);
        $admin->givePermissionTo($delete_tasks);

        // Manager
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo($manage_projects);
        $manager->givePermissionTo($create_tasks);
        $manager->givePermissionTo($edit_tasks);
        $manager->givePermissionTo($close_tasks);
        $manager->givePermissionTo($delete_tasks);

        // Staff
        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo($create_tasks);
        $staff->givePermissionTo($edit_tasks);
        $staff->givePermissionTo($close_tasks);

        // Client
        $client = Role::create(['name' => 'client']);

        // Freelance
        $freelance = Role::create(['name' => 'freelance']);
        $freelance->givePermissionTo($edit_tasks);
        $freelance->givePermissionTo($create_tasks);
        $freelance->givePermissionTo($close_tasks);

        if (App::isLocal()) {
            $emi = User::create(['name' => 'Emiliano', 'email' => 'info@thormaweb.com', 'password' => Hash::make('123')]);
            $emi->assignRole('admin');
        }

        app()['cache']->forget('spatie.permission.cache');
    }
}
