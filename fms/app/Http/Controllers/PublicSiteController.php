<?php
namespace App\Http\Controllers;
use App\Models\Flight;
class PublicSiteController extends Controller {
    public function index(){
        $flights = Flight::where('status','!=','cancelled')
            ->where('departure_time','>=', now()->subDay())
            ->with('departureAirport','arrivalAirport')
            ->orderBy('departure_time')->take(10)->get();
        return view('public.home', compact('flights'));
    }
}
