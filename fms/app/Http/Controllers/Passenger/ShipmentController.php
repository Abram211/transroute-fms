<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
class ShipmentController extends Controller {
    // Read-only for passengers; admin assigns shipments to their ticket
    public function index(){
        $shipments = Shipment::whereHas('ticket', fn($q) => $q->where('user_id',Auth::id()))
            ->with('flight.departureAirport','flight.arrivalAirport')
            ->latest()->get();
        return view('passenger.shipping.index', compact('shipments'));
    }
}
