<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUser()
    {
        return Auth::user()->load('roles.permissions');
    }

    public function getUsers()
    {
        return User::workForce()->get()->load('roles.permissions');
    }
}
