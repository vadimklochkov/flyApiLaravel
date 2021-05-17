<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FlightResource extends JsonResource
{
    private $date;
    public function __construct($resource, $date)
    {
        parent::__construct($resource);
        $this->date = $date;

    }

    public function toArray($request)
    {
        return [
                'flight_id' => $this->id,
                'flight_code' => $this->flight_code,
                'from' => [
                    'city' => $this->airportFrom->city,
                    'airport' => $this->airportFrom->name,
                    'iata' => $this->airportFrom->iata,
                    'date' => $this->date,
                    'city' => Carbon::createFromFormat('H:i:s', $this->time_from)->format('H:i')
                ],
                'to' => [
                    'city' => $this->airportTo->city,
                    'airport' => $this->airportTo->name,
                    'iata' => $this->airportTo->iata,
                    'date' => $this->date,
                    'city' => Carbon::createFromFormat('H:i:s', $this->time_to)->format('H:i'),
                ],
                'cost' => $this->cost,
                'availability' => $this->getAvailability($this->date)
            ];
    }
}
