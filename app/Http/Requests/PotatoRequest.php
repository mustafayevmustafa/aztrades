<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PotatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_whom' => 'required|string',
            'car_number' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'driver_cost' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'custom_cost' => 'nullable|numeric',
            'market_cost' => 'nullable|numeric',
            'total_weight' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
            'party' => 'nullable',
            'country_id' => 'required|integer',
            'sacs' => 'nullable|array',
            'is_trash' => 'nullable'
        ];
    }
}
