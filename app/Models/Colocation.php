<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'owner_id',
        'status',
        'token',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'colocation_user', 'colocation_id', 'user_id')
            ->withPivot('role', 'debt', 'sold', 'left_at', 'joined_at')
            ->wherePivotNull('left_at')
            ->withTimestamps();
    }


    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
