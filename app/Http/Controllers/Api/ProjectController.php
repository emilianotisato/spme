<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function postProject($clientId, ProjectRequest $request)
    {
        if (!Auth::user()->can('project_create')) {
            abort(403, 'Unauthorized action.');
        }

        $client = Client::findOrFail($clientId);
        return $client->projects()->create($request->all());
    }
}
