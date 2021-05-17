<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightSearchRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'from' => ['required', 'string', 'exists:airports,iata'],
            'to' => ['required', 'string', 'exists:airports,iata'],
            'date1' => ['required', 'date', 'date_format:"Y-m-d"'],
            'date2' => ['nullable', 'date', 'date_format:"Y-m-d"'],
            'passengers' => ['required', 'integer', 'between:1,8'],
        ];
    }
}
