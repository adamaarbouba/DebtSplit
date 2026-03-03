<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense_User extends Model
{
    // Explicitly defining the table name because of the double underscore
    protected $table = 'expense__users';

    protected $fillable = [
        'amount',
        'status',
        'user_id',
        'expense_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
