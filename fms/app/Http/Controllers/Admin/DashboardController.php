<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Flight,Ticket,Luggage,Shipment,User};
class DashboardController extends Controller {
    public function index(){
        $stats = [
            'total_passengers' => User::where('role','passenger')->count(),
            'total_revenue'    => Ticket::where('status','!=','cancelled')->sum('fare') + Shipment::where('status','!=','cancelled')->sum('fee'),
            'cargo_weight'     => Shipment::where('status','!=','cancelled')->sum('weight'),
            'active_flights'   => Flight::whereIn('status',['scheduled','boarding','delayed'])->count(),
        ];
        $recentFlights = Flight::with('departureAirport','arrivalAirport')->orderBy('departure_time','desc')->take(5)->get();
        return view('admin.dashboard', compact('stats','recentFlights'));
    }
}
