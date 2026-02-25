<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColocationController extends Controller
{
    //
    public function index()
    {
        $data = auth()->user()->colocations()
            ->withCount('users')
            ->get();

        return view('colocation.index')->with('colocations', $data);
    }
    public function show($id)
    {
        $colocation = auth()->user()->colocations()
            ->where('status', 'active')->with(['users', 'categories'])->findOrFail($id);

        return view('colocation.show', compact('colocation'));
    }
    public function dashboard()
    {
        $activeColocation = auth()->user()->colocations()->where('status', 'active')->first();

        return view('dashboard', compact('activeColocation'));
    }
}
