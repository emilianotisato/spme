<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Get clients collection
     *
     * @return void
     */
    public function getClients()
    {
        return Client::with('projects')->all();
    }

    /**
     * Create client
     *
     * @param ClientRequest $request
     * @return void
     */
    public function postClient(ClientRequest $request)
    {
        if (!Auth::user()->can('client_create')) {
            abort(403, 'Unauthorized action.');
        }

        return Client::create($request->all());
    }
}
