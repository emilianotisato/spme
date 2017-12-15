<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function resetpass(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/password/email');
    }
}
