<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('app');
        }

        return view('auth.login');
    }

    public function resetpass(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route('password.email');
    }
}
