<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Airport;
use App\Http\Resources\AirportSearchResource;


class AirportController extends Controller
{
    public function search(Request $request){
    	$airports = AirportSearchResource::collection(Airport::where('name','like','%' . $request['query'] . '%')
			->orWhere('city', 'like', '%' . $request['query'] . '%')
			->orWhere('iata', 'like', '%' . $request['query'] . '%')
			->get());
		return response()->json([
			'data' => ['items' => $airports]
		], 200);
	}
}