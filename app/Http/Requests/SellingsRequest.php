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
            'from_sell' => 'required|string',
            'type' => 'required|string',
            'content' => 'string',
            'type_id' => 'nullable|integer',
            'status' => 'nullable',
            'weight' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'sac_count' => 'nullable|numeric'
        ];
    }
}
