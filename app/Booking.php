<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Passenger;

class Booking extends Model
{
    protected $fillable = [
        'flight_from','flight_back', 'date_from', 
        'date_back', 'code'
    ];

     public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    protected static function boot()
    {
    	parent::boot();

    	self::creating(function($query){
    		$query->code = self::generateCode();
    	});
    }

    public static function generateCode()
    {
    	do {
    		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$code = '';
    		for ($i=0; $i < 5; $i++) { 
    			$code .= $letters[rand(0, 25)];
    		}
    	}while(Booking::where('code', $code)->count());
    	
    	return $code;
    }
}
