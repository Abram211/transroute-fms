<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        .card { border: 1px solid #d1d5db; border-radius: 10px; padding: 18px; margin-bottom: 16px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .title { font-size: 20px; font-weight: bold; color: #0f172a; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        th { background: #f3f4f6; }
        .totals { font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div>
                <div class="title">TransRoute Flight Receipt</div>
                <div class="muted">Document generated for passenger travel record</div>
            </div>
            <div>
                <div><strong>Receipt #:</strong> {{ $ticket->ticket_no }}</div>
                <div class="muted">Issued {{ now()->format('M d, Y H:i') }}</div>
            </div>
        </div>

        <div class="card">
            <strong>Passenger</strong>
            <div>{{ optional($ticket->passenger)->name ?? 'Unknown passenger' }}</div>
            <div class="muted">{{ optional($ticket->passenger)->email ?? 'No email provided' }}</div>
        </div>

        <div class="card">
            <strong>Flight Summary</strong>
            <div>Flight: {{ $ticket->flight->flight_number ?? '—' }}</div>
            <div>Route: {{ optional($ticket->flight->departureAirport)->city ?? 'Unknown' }} → {{ optional($ticket->flight->arrivalAirport)->city ?? 'Unknown' }}</div>
            <div>Departure: {{ optional($ticket->flight->departure_time)->format('M d, Y g:i A') ?? 'TBA' }}</div>
            <div>Seat: {{ $ticket->seat_no ?? 'Unassigned' }}</div>
            <div>Status: {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</div>
        </div>

        <div class="card">
            <strong>Linked Items</strong>
            @if($ticket->luggages->count() > 0 || $ticket->shipments->count() > 0)
                @if($ticket->luggages->count() > 0)
                    <div><strong>Luggage</strong></div>
                    <table>
                        <thead>
                            <tr><th>Item</th><th>Description</th><th>Weight</th><th>Fee</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach($ticket->luggages as $item)
                                <tr>
                                    <td>{{ $item->item_type }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->weight }} kg</td>
                                    <td>${{ number_format($item->fee, 2) }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if($ticket->shipments->count() > 0)
                    <div style="margin-top: 10px;"><strong>Shipments</strong></div>
                    <table>
                        <thead>
                            <tr><th>Shipment #</th><th>Description</th><th>Weight</th><th>Fee</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach($ticket->shipments as $item)
                                <tr>
                                    <td>{{ $item->shipment_no }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->weight }} kg</td>
                                    <td>${{ number_format($item->fee, 2) }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @else
                <div class="muted">No luggage or shipment items linked to this ticket.</div>
            @endif
        </div>

        <div class="card">
            <table>
                <tr><td>Ticket fare</td><td>${{ number_format($ticket->fare, 2) }}</td></tr>
                <tr><td>Linked items fees</td><td>${{ number_format($ticket->luggages->sum('fee') + $ticket->shipments->sum('fee'), 2) }}</td></tr>
                <tr class="totals"><td>Total</td><td>${{ number_format($ticket->fare + $ticket->luggages->sum('fee') + $ticket->shipments->sum('fee'), 2) }}</td></tr>
            </table>
        </div>
    </div>
</body>
</html>
