<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_whom' => 'nullable|string',
            'car_number' => 'nullable|string',
            'driver_name' => 'nullable|string',
            'driver_cost' => 'nullable|string',
            'cost' => 'nullable',
            'type' => 'nullable',
            'red_bag_number' => 'nullable',
            'yellow_bag_number' => 'nullable',
            'lom_bag_number' => 'nullable',
        ];
    }
}
