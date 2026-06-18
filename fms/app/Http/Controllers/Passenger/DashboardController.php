<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller {
    public function index(){
        $passenger = Auth::user();
        $activeTickets = Ticket::where('user_id',$passenger->id)
            ->whereIn('status',['pending','confirmed'])
            ->whereHas('flight', fn($q) => $q->where('departure_time','>',now()))
            ->with('flight.departureAirport','flight.arrivalAirport')
            ->orderBy(\App\Models\Flight::select('departure_time')->whereColumn('flights.id','tickets.flight_id'))
            ->get();
        $notifications = $passenger->flightNotifications()->take(10)->get();
        return view('passenger.dashboard', compact('activeTickets','notifications'));
    }
}
