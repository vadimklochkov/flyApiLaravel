<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Airport;
use App\Booking;
use App\Passenger;

class Flight extends Model
{
    protected $fillable = [
        'flight_code', 
        'from_id', 
        'to_id',
        'time_from',
        'time_to',
        'cost'
    ];
    public function airportFrom()
    {
        return $this->belongsTo(Airport::class,
        'from_id',
        'id');
    }
    public function airportTo()
    {
        return $this->belongsTo(Airport::class,
        'to_id',
        'id');
    }
    public function GetAvailability($date)
    {
        $bookings = Booking::where('date_from', $date)
            ->orWhere('date_back', $date);
        $bookings = $bookings->where('flight_back', $this->id)
            ->whereOr('flight_from', $this->id);
        $bookings = $bookings->get();
        $bookings_count = 0;
        foreach($bookings as $booking) {
            $bookings_count += $booking->passengers->count();
        }
        return 100 - $bookings_count;
    }
}
