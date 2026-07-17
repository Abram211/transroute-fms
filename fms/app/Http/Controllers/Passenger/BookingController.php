<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\{Flight,Ticket};
use App\Services\NotificationService;
use App\Services\TicketDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller {
    public function index(){
        $passenger = Auth::user();
        $tickets = Ticket::where('user_id',$passenger->id)->with('flight.departureAirport','flight.arrivalAirport')->latest()->get();
        $upcomingFlights = Flight::where('status','!=','cancelled')->where('departure_time','>',now())->with('departureAirport','arrivalAirport')->orderBy('departure_time')->get();
        return view('passenger.bookings.index', compact('tickets','upcomingFlights'));
    }
    public function store(Request $request){
        $request->validate(['flight_id'=>'required|exists:flights,id','seat_no'=>'nullable|string']);
        $flight = Flight::findOrFail($request->flight_id);
        if ($flight->seats_available <= 0) return back()->with('error','This flight is fully booked.');

        $ticket = Ticket::create([
            'ticket_no'=>'TK-'.strtoupper(uniqid()),
            'user_id'=>Auth::id(),
            'flight_id'=>$flight->id,
            'seat_no'=>$request->seat_no,
            'fare'=>$flight->base_fare,
            'status'=>'pending',
        ]);
        return redirect()->route('passenger.bookings.index')->with('success','Booking request submitted. Awaiting admin approval.');
    }
    public function downloadReceipt(Ticket $ticket, TicketDocumentService $service){
        abort_unless($ticket->user_id === Auth::id(), 403);

        $pdf = $service->createTicketReceipt($ticket);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="receipt-'.$ticket->ticket_no.'.pdf"');
    }

    // Passengers are allowed to cancel tickets
    public function cancel(Ticket $ticket){
        abort_unless($ticket->user_id === Auth::id(), 403);
        if (!$ticket->isCancellable()) {
            return back()->with('error','This ticket can no longer be cancelled.');
        }
        $ticket->update(['status'=>'cancelled']);
        app(NotificationService::class)->notifyBookingCancelled($ticket);
        return back()->with('success','Booking cancelled.');
    }
}
