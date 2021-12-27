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
            'from_sell' => 'from_sell|string',
            'to_sell' => 'to_sell|string',
            'content' => 'to_sell|string',
            'type' => 'nullable|numeric',
            'status' => 'nullable|numeric',
        ];
    }
}
