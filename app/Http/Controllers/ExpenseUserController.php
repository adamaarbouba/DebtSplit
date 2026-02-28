<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseUserController extends Controller
{

    public function markAsPaid(Request $request, Colocation $colocation, Expense $expense)
    {
        DB::beginTransaction();

        try {
            $userExpensePivot = DB::table('expense__users')
                ->where('expense_id', $expense->id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$userExpensePivot || $userExpensePivot->status === 'PAID') {
                return back()->with('info', 'This share is already paid or does not exist.');
            }

            $expense->users()->updateExistingPivot(auth()->id(), [
                'status' => 'PAID'
            ]);

            $housePivot = DB::table('colocation_user')
                ->where('colocation_id', $colocation->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($housePivot) {
                $newDebt = max(0, $housePivot->debt - $userExpensePivot->amount);

                DB::table('colocation_user')
                    ->where('colocation_id', $colocation->id)
                    ->where('user_id', auth()->id())
                    ->update(['debt' => $newDebt]);
            }

            $unpaidCount = DB::table('expense__users')
                ->where('expense_id', $expense->id)
                ->where('status', 'UNPAID')
                ->count();

            if ($unpaidCount === 0) {
                $expense->update(['status' => 'PAID']);
            }

            DB::commit();

            return back()->with('success', 'You have successfully marked your share as paid!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Could not update payment: ' . $e->getMessage()]);
        }
    }
}
