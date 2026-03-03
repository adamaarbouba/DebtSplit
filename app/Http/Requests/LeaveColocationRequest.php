<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class LeaveColocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Check if the user is actually an active member of this colocation
        return DB::table('colocation_user')
            ->where('colocation_id', $this->route('colocation')->id)
            ->where('user_id', auth()->id())
            ->whereNull('left_at') // Make sure they haven't already left
            ->exists();
    }

    public function rules(): array
    {
        return [];
    }
}
