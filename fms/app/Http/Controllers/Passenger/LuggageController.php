<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\Luggage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LuggageController extends Controller {
    public function index(){
        $luggages = Luggage::whereHas('ticket', fn($q) => $q->where('user_id',Auth::id()))
            ->with('ticket.flight.departureAirport','ticket.flight.arrivalAirport')
            ->latest()->get();
        return view('passenger.luggage.index', compact('luggages'));
    }
    // Passengers can only read and update STATUS (e.g. confirm pickup); cannot alter item/weight/fee
    public function updateStatus(Request $request, Luggage $luggage){
        abort_unless($luggage->ticket->user_id === Auth::id(), 403);
        $request->validate(['status'=>'required|in:picked']); // only allowed to confirm pickup
        $luggage->update(['status'=>$request->status]);
        return back()->with('success','Luggage status updated.');
    }
}
