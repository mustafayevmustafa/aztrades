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
            'cost' => 'nullable',
            'custom_cost' => 'nullable',
            'market_cost' => 'nullable',
            'total_weight' => 'nullable',
            'other_cost' => 'nullable',
            'potato_price' => 'nullable',
            'sacs' => 'nullable|array'
        ];
    }
}
