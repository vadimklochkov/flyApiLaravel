<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flight;
use App\Http\Requests\FlightSearchRequest;
use App\Http\Resources\FlightCollection;

class FlightController extends Controller
{
    public function search(FlightSearchRequest $request)
    {
    	$flightsTo = new FlightCollection(Flight::select('flights.*')
    		->join('airports', 'airports.id', '=', 'flights.from_id')
    		->where('airports.iata', $request->from)
    		->join('airports as airportsTwo', 'airportsTwo.id', '=', 'flights.to_id')
    		->where('airportsTwo.iata', $request->to)
    		->get(), $request->date1);
    	$flightsBack = [];
    	if($request->date2)
    		$flightsBack = new FlightCollection(Flight::select('flights.*')
    		->join('airports', 'airports.id', '=', 'flights.from_id')
    		->where('airports.iata', $request->to)
    		->join('airports as airportsTwo', 'airportsTwo.id', '=', 'flights.to_id')
    		->where('airportsTwo.iata', $request->from)
    		->get(), $request->date2);

    	return response()->json([
    		'data' => [
    			'flights_to' => $flightsTo,
    			"flights_back" => $flightsBack
    		]
    	]);
    }
}
