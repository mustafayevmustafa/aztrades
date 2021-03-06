<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'from_whom' => 'nullable|string',
            'car_number' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'driver_cost' => 'nullable|numeric',
            'supply_cost' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'red_bag_number' => 'nullable|integer',
            'yellow_bag_number' => 'nullable|integer',
            'lom_bag_number' => 'nullable|integer',
            'status' => 'nullable',
            'total_weight' => 'nullable|numeric',
            'city_id' => 'nullable|integer',
            'is_waste' => 'nullable|integer',
            'waste_weight' => 'nullable|numeric',
            'waste_sac_name' => 'nullable|string',
            'waste_sac_count' => 'nullable|integer',
        ];
    }
}
