<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinColocationRequest;
use App\Http\Requests\StoreColocationRequest;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColocationController extends Controller
{
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
            ->where('status', 'active')
            ->with(['users', 'categories'])
            ->findOrFail($id);

        return view('colocation.show', compact('colocation'));
    }

    public function create()
    {
        return view('colocation.create');
    }

    public function join()
    {
        return view('colocation.join');
    }

    public function processJoin(JoinColocationRequest $request)
    {
        $validated = $request->validated();

        $colocation = Colocation::where('token', $validated['token'])
            ->where('status', 'active')
            ->first();

        if (!$colocation) {
            return back()->withErrors(['token' => 'This colocation does not exist or is no longer active.']);
        }

        if ($colocation->users()->where('user_id', auth()->id())->exists()) {
            return back()->withErrors(['token' => 'You are already a member of this colocation.']);
        }

        $colocation->users()->attach(auth()->id(), [
            'role' => 'member',
            'joined_at' => now(),
            'sold' => 0,
            'debt' => 0,
        ]);

        return redirect()->route('colocation.show', $colocation->id)
            ->with('success', 'Welcome to ' . $colocation->title . '!');
    }

    //hadi nchangihaaaaaaaaaa mnb3d


    public function store(StoreColocationRequest $request)
    {
        $validated = $request->validated();

        $colocation = Colocation::create([
            'title' => $validated['title'],
            'owner_id' => auth()->id(),
            'status' => 'active',
            'token' => Str::random(10),
        ]);

        $colocation->users()->attach(auth()->id(), [
            'role' => 'Owner',
            'joined_at' => now(),
            'sold' => 0,
            'debt' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation created successfully!');
    }
    public function cancel($id)
    {
        $colocation = Colocation::findOrFail($id);

        if ($colocation->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action. Only the owner can cancel this colocation.');
        }

        $colocation->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation has been cancelled.');
    }
}
