<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellingsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'customer' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable',
            'weight' => 'nullable|numeric',
            'price' => 'required|numeric',
            'sac_name' => 'nullable|string',
            'sac_count' => 'required_with:sac_name,|nullable|numeric',
            'type' => 'nullable|string',
            'type_id' => 'nullable|integer',
        ];
    }
}
