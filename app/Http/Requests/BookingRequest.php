<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;
use App\Flight;
use App\Booking;
use App\Passenger;

class BookingRequest extends ApiRequest
{
    
    public function rules()
    {
        return [
            'flight_from.id' => ['required', 'integer', 'exists:flights,id'],
            'flight_from.date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'flight_back.id' => ['nullable', 'integer', 'exists:flights,id'],
            'flight_back.date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'passengers' => ['required', 'array'],
            'passengers.*.first_name' => ['required', 'string'],
            'passengers.*.last_name' => ['required', 'string'],
            'passengers.*.birth_date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'passengers.*.document_number' => ['required', 'string', 'digits:10'],
        ];
    }
}
