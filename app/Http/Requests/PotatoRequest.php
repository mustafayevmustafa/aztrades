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
            'driver_cost' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'custom_cost' => 'nullable|numeric',
            'market_cost' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
            'total_weight' => 'nullable|numeric',
            'party' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'status' => 'nullable',
            'sacs' => 'nullable|array',
            'sacs.*.id'   => 'nullable|integer',
            'sacs.*.name'   => 'required|string',
            'sacs.*.sac_count'   => 'required|string',
            'sacs.*.sac_weight'   => 'required|string',
            'is_waste' => 'nullable|integer',
            'waste_weight' => 'nullable|numeric',
            'waste_sac_name' => 'nullable|integer',
            'waste_sac_count' => 'nullable|integer',
        ];
    }
}
