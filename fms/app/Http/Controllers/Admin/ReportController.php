<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Flight,Ticket,Shipment};
use Illuminate\Support\Facades\DB;
class ReportController extends Controller {
    public function index(){
        $report = Flight::select('flights.id')
            ->with('departureAirport','arrivalAirport')
            ->withCount(['tickets as passenger_count' => fn($q) => $q->whereIn('status',['confirmed','completed'])])
            ->get()
            ->map(function($f){
                $tickets = Ticket::where('flight_id',$f->id)->whereIn('status',['confirmed','completed'])->get();
                $shipments = Shipment::where('flight_id',$f->id)->where('status','!=','cancelled')->get();
                return [
                    'flight' => $f,
                    'passenger_count' => $tickets->count(),
                    'ticket_revenue' => $tickets->sum('fare'),
                    'weight' => $shipments->sum('weight'),
                    'shipment_revenue' => $shipments->sum('fee'),
                ];
            });
        $totals = [
            'passengers' => $report->sum('passenger_count'),
            'tickets' => $report->sum('passenger_count'),
            'weight' => $report->sum('weight'),
            'revenue' => $report->sum('ticket_revenue') + $report->sum('shipment_revenue'),
        ];
        return view('admin.reports.index', compact('report','totals'));
    }
}
