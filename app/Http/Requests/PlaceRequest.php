<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;


class PlaceRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'passenger' => ['required', 'integer', 'exists:passengers,id'],
            'seat' => ['required', 'string', 'max:3'],
            'type' => ['required', 'in:from,back']
        ];
    }
}
