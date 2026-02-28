<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses()->with('category')->latest()->get();

        return view('expense.index', compact('expenses'));
    }

    public function create(Colocation $colocation)
    {
        if (!$colocation->users()->where('user_id', auth()->id())->exists()) {
            abort(403, 'You are not a member of this colocation.');
        }

        $colocation->load(['categories', 'users']);

        return view('expense.create', compact('colocation'));
    }

    public function store(Request $request, Colocation $colocation)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'total_payment' => 'required|numeric|min:0.01',
            'split_with' => 'required|array',
            'split_with.*' => 'exists:users,id'
        ]);

        DB::beginTransaction();

        try {
            $expense = Expense::create([
                'creator_id' => auth()->id(),
                'payer_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'total_payment' => $validated['total_payment'],
                'status' => 'UNPAID',
            ]);

            $numberOfPeople = count($validated['split_with']);
            $amountPerPerson = round($validated['total_payment'] / $numberOfPeople, 2);

            foreach ($validated['split_with'] as $userId) {

                $expense->users()->attach($userId, [
                    'amount' => $amountPerPerson,
                    'status' => 'UNPAID'
                ]);

                if ($userId != auth()->id()) {
                    $pivot = DB::table('colocation_user')
                        ->where('colocation_id', $colocation->id)
                        ->where('user_id', $userId)
                        ->first();

                    if ($pivot) {
                        DB::table('colocation_user')
                            ->where('colocation_id', $colocation->id)
                            ->where('user_id', $userId)
                            ->update(['debt' => $pivot->debt + $amountPerPerson]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('colocation.show', $colocation->id)
                ->with('success', 'Expense of ' . $validated['total_payment'] . ' DH logged successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    public function show(Expense $expense)
    {
        $expense->load(['users', 'category', 'creator', 'payer']);

        return view('expense.show', compact('expense'));
    }
}
