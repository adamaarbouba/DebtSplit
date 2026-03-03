<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('colocation')->users()->where('user_id', auth()->id())->exists();
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'total_payment' => ['required', 'numeric', 'min:0.01'],
            'split_with' => ['required', 'array'],
            'split_with.*' => ['exists:users,id']
        ];
    }
}
