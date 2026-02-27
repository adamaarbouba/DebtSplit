<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Redirect extends Controller
{
    //
    public function dashboard()
    {
        $activeColocation = auth()->user()->colocations()->where('status', 'active')->first();
        // dd($activeColocation);
        return view('dashboard', compact('activeColocation'));
    }
}
