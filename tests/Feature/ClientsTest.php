<?php

namespace Tests\Feature;

use Tests\TestCase;
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

        $this->authUser()
        ->withRoles(['admin'])
        ->withPermissions([
            'client_create',
            'client_edit',
            'client_deactivate',
            'client_delete',
            'client_see_secret',
            'client_add_notes'
            ]);

    }
    /** @test */
    public function can_create_clients_only_with_name()
    {
        // Given we only have the client name (e.g: Vue quick create component)
        $name = 'Demo Client';

        // When I post to create endpoint
        $response = $this->post(route('post-client'), ['name' => $name]);

        // Then we have returned a new client with the rest of the field by default
        $response->assertSuccessful();
        $response->assertJsonFragment(['name' => $name]);
    }
}
