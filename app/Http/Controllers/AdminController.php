<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized. Admins only.');
        }

        $usersQuery = User::where('role_id', '!=', 1);

        $totalUsers = (clone $usersQuery)->count();
        $bannedUsers = (clone $usersQuery)->where('status', 'banned')->count();

        $users = $usersQuery->latest()->paginate(15);

        return view('admin.dashboard', compact('users', 'totalUsers', 'bannedUsers'));
    }
    public function toggleBan(User $user)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized. Admins only.');
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot ban yourself.']);
        }

        if ($user->role_id === 1) {
            return back()->withErrors(['error' => 'You cannot ban another admin.']);
        }

        if ($user->status === 'banned') {
            $user->update(['status' => null]);
            $message = $user->name . ' has been successfully unbanned.';
        } else {
            $user->update(['status' => 'banned']);
            $message = $user->name . ' has been banned from the platform.';
        }

        return back()->with('success', $message);
    }
}
