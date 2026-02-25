<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation_user extends Model
{
    //
    protected $fillable = [
        'joined_at',
        'left_at',
        'role',
        'sold',
        'debt',
        'user_id',
        'colocation_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function colocation()
    {
        return $this->belongsTo(User::class);
    }
}
