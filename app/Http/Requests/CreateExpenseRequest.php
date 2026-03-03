<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('colocation')->users()->where('user_id', auth()->id())->exists();
    }

    public function rules(): array
    {
        return [];
    }
}
