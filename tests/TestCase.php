<?php

namespace Tests;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $authUser;

    public function authUser($name = 'Demo User')
    {
        $this->authUser = factory(\App\User::class)->create(['name' => $name]);
        Auth::loginUsingId($this->authUser->id, true);

        return $this;
    }

    public function withRoles($roles = [])
    {
        foreach($roles as $role) {

            Role::create(['name' => $role]);

            $this->authUser->assignRole($role);
        }

        return $this;
    }

    public function withPermissions($permissions = [])
    {
        foreach($permissions as $permission) {

            Permission::create(['name' => $permission]);

            $this->authUser->givePermissionTo($permission);
        }

        return $this;
    }
}
