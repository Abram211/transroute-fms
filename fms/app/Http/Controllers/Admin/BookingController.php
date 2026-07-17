<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Flight,Ticket,User};
use App\Services\NotificationService;
use App\Services\TicketDocumentService;
use Illuminate\Http\Request;
class BookingController extends Controller {
    public function index(){
        $pendingTickets = Ticket::with('passenger','flight.departureAirport','flight.arrivalAirport')
            ->where('status','pending')->orderBy('created_at')->get();
        $confirmedTickets = Ticket::with('passenger','flight.departureAirport','flight.arrivalAirport')
            ->where('status','confirmed')->orderBy('created_at','desc')->take(20)->get();
        $cancelledTickets = Ticket::with('passenger','flight.departureAirport','flight.arrivalAirport')
            ->whereIn('status',['cancelled','no_show'])->orderBy('updated_at','desc')->take(20)->get();
        $flights = Flight::where('status','!=','cancelled')->where('departure_time','>',now())->with('departureAirport','arrivalAirport')->get();
        $passengers = User::where('role','passenger')->orderBy('name')->get();
        return view('admin.bookings.index', compact('pendingTickets','confirmedTickets','cancelledTickets','flights','passengers'));
    }
    public function store(Request $request){
        $request->validate(['user_id'=>'required|exists:users,id','flight_id'=>'required|exists:flights,id','seat_no'=>'nullable|string','fare'=>'required|numeric|min:0']);
        $flight = Flight::findOrFail($request->flight_id);
        $ticket = Ticket::create([
            'ticket_no'=>'TK-'.strtoupper(uniqid()),
            'user_id'=>$request->user_id,
            'flight_id'=>$request->flight_id,
            'seat_no'=>$request->seat_no,
            'fare'=>$request->fare,
            'status'=>'confirmed',
        ]);
        app(NotificationService::class)->notifyBookingConfirmed($ticket);
        return redirect()->route('admin.bookings.index')->with('success','Booking created and confirmed.');
    }
    public function downloadReceipt(Ticket $ticket, TicketDocumentService $service){
        $pdf = $service->createTicketReceipt($ticket);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="receipt-'.$ticket->ticket_no.'.pdf"');
    }

    public function approve(Ticket $ticket){
        $ticket->update(['status'=>'confirmed']);
        app(NotificationService::class)->notifyBookingConfirmed($ticket);
        return back()->with('success','Booking approved.');
    }
    // Admin cancels for no-shows; data retained, marked cancelled (not deleted)
    public function cancel(Ticket $ticket){
        $ticket->update(['status'=>'no_show']);
        return back()->with('success','Ticket marked as cancelled (no-show). Record retained.');
    }
}
