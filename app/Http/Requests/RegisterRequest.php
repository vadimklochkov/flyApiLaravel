<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ApiRequest;




class RegisterRequest extends ApiRequest
{
  
    public function rules()
    {
        return [
            
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:users'],
            'document_number' => ['required', 'string', 'digits:10'],
            'password' => ['required', 'string'],
        ];
    }

}
