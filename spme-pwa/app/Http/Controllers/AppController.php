<?php

namespace App\Http\Controllers;

use App\System;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        if (System::isFirstInstall()) {
            dd('run installer...');
        }
        return view('app');
    }

    public function resetpass(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/password/email');
    }
}
