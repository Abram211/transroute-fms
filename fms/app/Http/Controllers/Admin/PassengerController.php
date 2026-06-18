<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
class PassengerController extends Controller {
    public function index(){
        $passengers = User::where('role','passenger')->with(['tickets.flight.departureAirport','tickets.flight.arrivalAirport','tickets.luggages'])->get();
        return view('admin.passengers.index', compact('passengers'));
    }
}
