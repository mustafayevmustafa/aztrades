<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expense_type_id' => 'required|integer',
            'expense' => 'required|numeric',
            'note' => 'nullable|string',
            'back' => 'nullable|string',
            'is_returned' => 'nullable',
            'is_income' => 'nullable',
            'customer' => 'nullable|string'
        ];
    }
}
