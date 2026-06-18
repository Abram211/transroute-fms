<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Airport,Flight};
use Illuminate\Http\Request;
class FlightController extends Controller {
    public function index(){
        $activeFlights = Flight::with('departureAirport','arrivalAirport')
            ->where('status','!=','cancelled')
            ->orderBy('departure_time')->get();
        $cancelledFlights = Flight::with('departureAirport','arrivalAirport')
            ->where('status','cancelled')
            ->orderBy('departure_time','desc')->get();
        $airports = Airport::orderBy('city')->get();
        return view('admin.flights.index', compact('activeFlights','cancelledFlights','airports'));
    }
    public function store(Request $request){
        $request->validate([
            'flight_number'=>'required|string|unique:flights',
            'departure_airport_id'=>'required|exists:airports,id|different:arrival_airport_id',
            'arrival_airport_id'=>'required|exists:airports,id',
            'departure_time'=>'required|date',
            'arrival_time'=>'required|date|after:departure_time',
            'gate'=>'nullable|string',
            'capacity'=>'required|integer|min:1',
            'base_fare'=>'required|numeric|min:0',
        ]);
        Flight::create($request->all());
        return redirect()->route('admin.flights.index')->with('success','Flight schedule added.');
    }
    public function update(Request $request, Flight $flight){
        $request->validate([
            'flight_number'=>'required|string|unique:flights,flight_number,'.$flight->id,
            'departure_airport_id'=>'required|exists:airports,id',
            'arrival_airport_id'=>'required|exists:airports,id',
            'departure_time'=>'required|date',
            'arrival_time'=>'required|date|after:departure_time',
            'status'=>'required|in:scheduled,boarding,delayed,departed,arrived,cancelled',
        ]);
        $wasDelayed = $request->status === 'delayed' && $flight->status !== 'delayed';
        $flight->update($request->all());

        if ($wasDelayed) {
            app(\App\Services\NotificationService::class)->notifyFlightDelayed($flight);
        }
        return redirect()->route('admin.flights.index')->with('success','Flight updated.');
    }
    public function cancel(Flight $flight){
        // Soft cancel - keep record, mark cancelled, cascade to cancel pending/confirmed tickets (no-show handling done separately)
        $flight->update(['status'=>'cancelled']);
        $flight->tickets()->whereIn('status',['pending','confirmed'])->update(['status'=>'cancelled']);
        return back()->with('success','Flight cancelled. Data retained for records.');
    }
}
