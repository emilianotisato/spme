<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUser()
    {
        // TODO: load roles ->load('roles')
        return Auth::user();
    }

    public function getUsers()
    {
        return User::all();
    }
}
