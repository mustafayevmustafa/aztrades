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
            'supply_cost' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'type' => 'nullable|string',
            'red_bag_number' => 'nullable|integer',
            'yellow_bag_number' => 'nullable|integer',
            'lom_bag_number' => 'nullable|integer',
            'onion_price' => 'nullable|numeric',
            'onion_trash' => 'nullable',
            'total_weight' => 'nullable|numeric'
        ];
    }
}
