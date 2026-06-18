<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Shipment,Flight,Ticket};
use Illuminate\Http\Request;
class ShipmentController extends Controller {
    public function index(){
        $shipments = Shipment::with('flight.departureAirport','flight.arrivalAirport','ticket.passenger')->latest()->get();
        $flights = Flight::where('status','!=','cancelled')->with('departureAirport','arrivalAirport')->get();
        $tickets = Ticket::with('passenger')->where('status','!=','cancelled')->get();
        return view('admin.shipping.index', compact('shipments','flights','tickets'));
    }
    // Only admin allowed to add shipping
    public function store(Request $request){
        $request->validate([
            'flight_id'=>'required|exists:flights,id',
            'ticket_id'=>'nullable|exists:tickets,id',
            'sender_name'=>'required|string',
            'sender_phone'=>'nullable|string',
            'receiver_name'=>'required|string',
            'receiver_phone'=>'nullable|string',
            'description'=>'nullable|string',
            'weight'=>'required|numeric|min:0',
            'fee'=>'required|numeric|min:0',
        ]);
        Shipment::create([...$request->all(), 'shipment_no'=>'SHP-'.strtoupper(uniqid()), 'status'=>'loaded']);
        return redirect()->route('admin.shipping.index')->with('success','Shipment registered.');
    }
    public function update(Request $request, Shipment $shipment){
        $request->validate(['status'=>'required|in:loaded,in_transit,delivered,cancelled','weight'=>'required|numeric|min:0','fee'=>'required|numeric|min:0']);
        $shipment->update($request->all());
        return redirect()->route('admin.shipping.index')->with('success','Shipment updated.');
    }
    public function destroy(Shipment $shipment){
        $shipment->update(['status'=>'cancelled']);
        return back()->with('success','Shipment cancelled (retained in records).');
    }
}
