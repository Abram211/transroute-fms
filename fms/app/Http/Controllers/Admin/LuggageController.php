<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Luggage,Ticket};
use Illuminate\Http\Request;
class LuggageController extends Controller {
    public function index(){
        $luggages = Luggage::with('ticket.passenger','ticket.flight')->latest()->get();
        $tickets = Ticket::with('passenger','flight')->where('status','!=','cancelled')->get();
        return view('admin.luggage.index', compact('luggages','tickets'));
    }
    // Only admin can add luggage
    public function store(Request $request){
        $request->validate(['ticket_id'=>'required|exists:tickets,id','item_type'=>'required|string','description'=>'nullable|string','weight'=>'required|numeric|min:0','fee'=>'required|numeric|min:0']);
        Luggage::create([
            'luggage_code'=>'LUG-'.strtoupper(uniqid()),
            'ticket_id'=>$request->ticket_id,
            'item_type'=>$request->item_type,
            'description'=>$request->description,
            'weight'=>$request->weight,
            'fee'=>$request->fee,
            'status'=>'checked_in',
        ]);
        return redirect()->route('admin.luggage.index')->with('success','Luggage added to passenger record.');
    }
    // Only admin can alter luggage (besides status, which passenger can update)
    public function update(Request $request, Luggage $luggage){
        $request->validate(['item_type'=>'required|string','description'=>'nullable|string','weight'=>'required|numeric|min:0','fee'=>'required|numeric|min:0','status'=>'required|in:pending,checked_in,in_transit,picked,cancelled']);
        $luggage->update($request->all());
        return redirect()->route('admin.luggage.index')->with('success','Luggage updated.');
    }
    public function destroy(Luggage $luggage){
        // cancel rather than hard delete to preserve history
        $luggage->update(['status'=>'cancelled']);
        return back()->with('success','Luggage entry cancelled (retained in records).');
    }
}
