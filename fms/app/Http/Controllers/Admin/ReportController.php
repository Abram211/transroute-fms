<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Flight,Ticket,Shipment};
use App\Services\TicketDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class ReportController extends Controller {
    public function index(Request $request){
        $period = $request->get('period', 'monthly');
        [$from, $to, $label] = $this->getPeriodRange($period);
        $report = $this->buildReport($from, $to);
        $totals = [
            'passengers' => $report->sum('passenger_count'),
            'tickets' => $report->sum('passenger_count'),
            'weight' => $report->sum('weight'),
            'revenue' => $report->sum('ticket_revenue') + $report->sum('shipment_revenue'),
        ];

        return view('admin.reports.index', compact('report','totals','period','label','from','to'));
    }

    public function download(Request $request, TicketDocumentService $service){
        $period = $request->get('period', 'monthly');
        [$from, $to] = $this->getPeriodRange($period);
        $report = $this->buildReport($from, $to);

        $totals = [
            'passengers' => $report->sum('passenger_count'),
            'tickets' => $report->sum('passenger_count'),
            'weight' => $report->sum('weight'),
            'revenue' => $report->sum('ticket_revenue') + $report->sum('shipment_revenue'),
        ];

        $pdf = $service->createFlightReport($report->toArray(), $totals);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="transroute-'.$period.'-report.pdf"');
    }

    protected function buildReport(Carbon $from, Carbon $to){
        return Flight::with('departureAirport','arrivalAirport')
            ->get()
            ->map(function($flight) use ($from, $to){
                $tickets = Ticket::where('flight_id', $flight->id)
                    ->whereBetween('created_at', [$from, $to])
                    ->whereIn('status', ['confirmed', 'completed'])
                    ->get();
                $shipments = Shipment::where('flight_id', $flight->id)
                    ->whereBetween('created_at', [$from, $to])
                    ->where('status', '!=', 'cancelled')
                    ->get();

                return [
                    'flight' => $flight,
                    'passenger_count' => $tickets->count(),
                    'ticket_revenue' => $tickets->sum('fare'),
                    'weight' => $shipments->sum('weight'),
                    'shipment_revenue' => $shipments->sum('fee'),
                ];
            })
            ->filter(fn($row) => $row['passenger_count'] > 0 || $row['weight'] > 0 || $row['ticket_revenue'] > 0 || $row['shipment_revenue'] > 0);
    }

    protected function getPeriodRange(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'daily' => [$now->copy()->startOfDay(), $now->copy()->endOfDay(), 'Daily Report'],
            'weekly' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek(), 'Weekly Report'],
            'monthly' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'Monthly Report'],
            'annual' => [$now->copy()->startOfYear(), $now->copy()->endOfYear(), 'Annual Report'],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'Monthly Report'],
        };
    }
}
