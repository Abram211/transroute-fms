<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\Flight;
class ScheduleController extends Controller {
    public function index(){
        $flights = Flight::where('status','!=','cancelled')->where('departure_time','>=', now()->subDay())
            ->with('departureAirport','arrivalAirport')->orderBy('departure_time')->get();
        return view('passenger.schedule.index', compact('flights'));
    }
}
