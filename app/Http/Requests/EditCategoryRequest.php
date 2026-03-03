<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('colocation')->owner_id === auth()->id();
    }

    public function rules(): array
    {
        return [];
    }
}
