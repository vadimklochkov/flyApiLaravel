<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Flight;
use App\Booking;
use App\Http\Resources\PassengerBookingResource;
use App\Passenger;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    public function store(BookingRequest $request)
    {
    	$passengersCount = count($request->passengers());
    	if($request->flight_back)
    		if(Flight::find($request->flight_from['id'])->getAvailability($request->flight_from['date'])
    			< $passengersCount or
    			Flight::find($request->flight_back['id'])->getAvailability($request->flight_back['date'])
    			< $passengersCount) {
    			return response()->json(['message' => 'Недостаточно свободных мест на рейсах'], 403);
    		}
    	else
    		if(Flight::find($request->flight_from['id'])->getAvailability($request->flight_from['date'])
    			< $passengersCount) {
    			return response()->json(['message' => 'Недостаточно свободных мест на рейсах'], 403);
    		}
    		$booking = Booking::create([
    			'flight_from' => $request->flight_from['id'],
    			'flight_back' => $request->flight_back['id'],
    			'date_from' => $request->flight_from['date'],
    			'date_back' => $request->flight_back['date'],
    		]);

    		foreach ($request->passengers as $passenger) {
    			Passenger::create([
    			'booking_id' => $booking->id,
    			'first_name' => $passenger['first_name'],
    			'last_name' => $passenger['last_name'],
    			'birth_date' => $passenger['birth_date'],
    			'document_number' => $passenger['document_number'],
    		]);
    	}
    	return response()->json(['data' => ['code' => $booking->code]], 201);
    		
    }

    public function show($code)
    {
        $booking = new BookingResource(Booking::where('code',$code)->first());

        return response()->json(['data' => $booking]);
    }

    public function getSeats($code){
        $booking = Booking::where('code', $code)->first();
        $occupiedFrom = [];
        $occupiedBack = [];
        foreach ($booking->passengers as $passenger) {
            if($passenger['place_from'])
                $occupiedFrom[] = [
                    'passenger_id' => $passenger['id'],
                    'place' => $passenger['place_from']
                ];
            if($passenger['place_back'])
                $occupiedBack[] = [
                    'passenger_id' => $passenger['id'],
                    'place' => $passenger['place_back']
                ];
        }
        $response = [
            'data' => [
                'occupied_from' => $occupiedFrom,
                'occupied_back' => $occupiedBack
            ]
        ];
        return response()->json($response);
    }
}
