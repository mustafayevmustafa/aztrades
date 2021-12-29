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
            'customer' => 'required|string',
            'content' => 'nullable|string',
            'status' => 'nullable',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'sac_name' => 'nullable|string',
            'sac_count' => 'required_with:sac_name,|nullable|numeric',
            'type' => 'nullable|string',
            'type_id' => 'nullable|integer',
        ];
    }
}
