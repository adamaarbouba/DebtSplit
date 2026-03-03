<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\IndexExpenseRequest;
use App\Http\Requests\ShowExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(IndexExpenseRequest $request)
    {
        $expenses = auth()->user()->expenses()->with('category')->latest()->get();

        return view('expense.index', compact('expenses'));
    }

    public function create(CreateExpenseRequest $request, Colocation $colocation)
    {
        $colocation->load(['categories', 'users']);

        return view('expense.create', compact('colocation'));
    }

    public function store(StoreExpenseRequest $request, Colocation $colocation)
    {
        $validated = $request->validated();

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

    public function show(ShowExpenseRequest $request, Expense $expense)
    {
        $expense->load(['users', 'category', 'creator', 'payer']);

        return view('expense.show', compact('expense'));
    }
}
