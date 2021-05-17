<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends ApiRequest
{
    
    public function rules()
    {
        return [
            'phone' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }
}
