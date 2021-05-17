<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class FlightCollection extends ResourceCollection
{
    private $date;

    public function __construct($resource, $dateFromController = null)
    {
        parent::__construct($resource);
        $this->date = $dateFromController;
    }

    public function toArray($request)
    {
        return $this->collection->map(function($flight){
            return [
                'flight_id' => $flight->id,
                'flight_code' => $flight->flight_code,
                'from' => [
                    'city' => $flight->airportFrom->city,
                    'airport' => $flight->airportFrom->name,
                    'iata' => $flight->airportFrom->iata,
                    'date' => $this->date,
                    'city' => Carbon::createFromFormat('H:i:s', $flight->time_from)->format('H:i')
                ],
                'to' => [
                    'city' => $flight->airportTo->city,
                    'airport' => $flight->airportTo->name,
                    'iata' => $flight->airportTo->iata,
                    'date' => $this->date,
                    'city' => Carbon::createFromFormat('H:i:s', $flight->time_to)->format('H:i'),
                ],
                'cost' => $flight->cost,
                'availability' => $flight->getAvailability($this->date)
            ];
        });
    }
}
