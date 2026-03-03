<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinColocationRequest;
use App\Http\Requests\LeaveColocationRequest;
use App\Http\Requests\StoreColocationRequest;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
    public function leave(LeaveColocationRequest $request, Colocation $colocation)
    {
        $user = auth()->user();

        $pivot = DB::table('colocation_user')
            ->where('colocation_id', $colocation->id)
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->first();

        if (!$pivot) {
            return back()->withErrors(['error' => 'You are not active in this colocation.']);
        }

        DB::beginTransaction();

        try {
            if ($pivot->debt > 0) {
                $user->decrement('rep');

                $remainingUsers = DB::table('colocation_user')
                    ->where('colocation_id', $colocation->id)
                    ->where('user_id', '!=', $user->id)
                    ->whereNull('left_at')
                    ->get();

                if ($remainingUsers->count() > 0) {
                    $splitAmount = round($pivot->debt / $remainingUsers->count(), 2);

                    foreach ($remainingUsers as $remainingUser) {
                        DB::table('colocation_user')
                            ->where('colocation_id', $colocation->id)
                            ->where('user_id', $remainingUser->user_id)
                            ->increment('debt', $splitAmount);
                    }
                }
            }

            DB::table('colocation_user')
                ->where('colocation_id', $colocation->id)
                ->where('user_id', $user->id)
                ->update([
                    'left_at' => now(),
                    'debt' => 0
                ]);

            $activeRoommates = DB::table('colocation_user')
                ->where('colocation_id', $colocation->id)
                ->whereNull('left_at')
                ->get();

            if ($activeRoommates->isEmpty()) {
                $colocation->update(['status' => 'cancelled']);
            } else {
                if ($colocation->owner_id === $user->id) {
                    $newOwner = $activeRoommates->first();

                    $colocation->update(['owner_id' => $newOwner->user_id]);

                    DB::table('colocation_user')
                        ->where('colocation_id', $colocation->id)
                        ->where('user_id', $newOwner->user_id)
                        ->update(['role' => 'Owner']);
                }
            }

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'You have successfully left the house.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Could not leave: ' . $e->getMessage()]);
        }
    }


    public function kick(Colocation $colocation, User $user)
    {
        if ($colocation->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot kick yourself. Please use the Leave button.']);
        }

        $pivot = DB::table('colocation_user')
            ->where('colocation_id', $colocation->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$pivot) {
            return back()->withErrors(['error' => 'User is not in this colocation.']);
        }

        DB::beginTransaction();

        try {
            if ($pivot->debt > 0) {
                DB::table('colocation_user')
                    ->where('colocation_id', $colocation->id)
                    ->where('user_id', auth()->id())
                    ->increment('debt', $pivot->debt);
            }

            DB::table('colocation_user')
                ->where('colocation_id', $colocation->id)
                ->where('user_id', $user->id)
                ->update([
                    'left_at' => now(),
                    'debt' => 0
                ]);

            DB::commit();
            return back()->with('success', $user->name . ' has been kicked from the house.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Could not kick user: ' . $e->getMessage()]);
        }
    }

    public function refreshToken(Colocation $colocation)
    {
        if ($colocation->owner_id !== auth()->id()) {
            exit();
        }

        $colocation->update([
            'token' => Str::random(10)
        ]);

        return back()->with('success', 'New invite token generated successfully!');
    }
}
