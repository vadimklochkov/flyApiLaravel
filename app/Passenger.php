<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Passenger;
use App\Booking;

class Passenger extends Model
{
    protected $fillable = [
        'booking_id','first_name', 'last_name', 
        'birth_date', 'document_number','place_from','place_back'
    ];

    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }
}
