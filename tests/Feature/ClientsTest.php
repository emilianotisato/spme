<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test class authenticating a user with all the permissions on clien model
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $client_create = Permission::create(['name' => 'client_create']);
        $client_edit = Permission::create(['name' => 'client_edit']);
        $client_deactivate = Permission::create(['name' => 'client_deactivate']);
        $client_delete = Permission::create(['name' => 'client_delete']);
        $client_see_secret = Permission::create(['name' => 'client_see_secret']);
        $client_add_notes = Permission::create(['name' => 'client_add_notes']);
        $admin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $admin->givePermissionTo($client_create);
        $admin->givePermissionTo($client_edit);
        $admin->givePermissionTo($client_deactivate);
        $admin->givePermissionTo($client_delete);
        $admin->givePermissionTo($client_see_secret);
        $admin->givePermissionTo($client_add_notes);

        $user = factory(\App\User::class)->create(['name' => 'Admin man']);
        $user->assignRole('admin');

        Auth::loginUsingId($user->id, true);

    }
    /** @test */
    public function can_create_clients_only_with_name()
    {
        // Given we only have the client name (Vue quick create component)
        $name = 'Demo Client';

        // When I post to create endpoint
        $response = $this->post('/post-client', ['name' => $name]);

        // Then we have return a new client with the rest of the field by default
        $response->assertSuccessful();
        $response->assertJsonFragment(['name' => $name]);
    }
}
