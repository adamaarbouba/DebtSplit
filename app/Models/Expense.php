<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //    
    protected $fillable = [
        'total_payment',
        'category_id',
        'status',
        'creator_id',
        'payer_id',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
