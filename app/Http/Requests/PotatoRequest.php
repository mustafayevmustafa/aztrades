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
            'from_whom' => 'nullable|string',
            'car_number' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'custom_cost' => 'nullable|numeric',
            'market_cost' => 'nullable|numeric',
            'total_weight' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
            'potato_price' => 'nullable|numeric',
            'sacs' => 'nullable|array'
        ];
    }
}
