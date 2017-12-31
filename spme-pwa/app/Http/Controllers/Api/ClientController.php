<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function getClients()
    {
        return Client::all()->load('projects');
    }
}
