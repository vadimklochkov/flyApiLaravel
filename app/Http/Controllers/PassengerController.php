<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlaceRequest;
use App\Booking;
use App\Passenger;
use App\Http\Resources\PassengerBookingResource;

class PassengerController extends Controller
{
    public function takePlace(PlaceRequest $request, $code){
    	$booking = Booking::where('code', $code)
    		->first();
    	if(empty($booking))
    		return response()->json(['message' => 'Бронирование не существует'], 404);
    	if(!$booking->passengers->where('id', $request->passenger)->count()) {
    		return response()->json([
    			'errors' => [
    				'code' => 403,
    				'message' => 'Passenger does not apply to booking'
    			]
    		], 403);
    	}

    	$isOccupied = false;
    	if($request->type === 'from')
    		$id = $booking->flight_from;
    	else 
    		$id = $booking->flight_back;
    	
    	$bookingsFrom = Booking::where('flight_from', $id)
    		->where('date_from', $booking->date_from)
    		->get();
    	$bookingsBack = Booking::where('flight_back', $id)
    		->where('date_back', $booking->date_back)
    		->get();

    	foreach ($bookingsFrom as $book) {
    		if($book->passengers->where('place_from', $request->seat)->count())
    			$isOccupied = true;
    	}
    	foreach ($bookingsBack as $book) {
    		if($book->passengers->where('place_back', $request->seat)->count())
    			$isOccupied = true;
    	}
    	if($isOccupied)
    		return response()->json([
    			'error' => [
    				'code' => 422,
    				'message' => 'Seat is occupied'
    			]
    		], 422);

    	$passenger = Passenger::find($request->passenger);
    	if($request->type === 'from')
    		$passenger->update([
    			'place_from' => $request->seat
    		]);
    	else 
    		$passenger->update([
    			'place_back' => $request->seat
    		]);
    	return response()->json( new PassengerBookingResource($passenger));
    }
}
