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
        'status',
        'token',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'colocation_user', 'colocation_id', 'user_id')->withPivot('joined_at', 'left_at', 'sold', 'debt')->withTimestamps();
    }


    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
