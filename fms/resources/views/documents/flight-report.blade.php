<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        .card { border: 1px solid #d1d5db; border-radius: 10px; padding: 16px; margin-bottom: 14px; }
        .title { font-size: 20px; font-weight: bold; color: #0f172a; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">TransRoute Flight Operations Report</div>
        <div class="muted">Generated {{ now()->format('M d, Y H:i') }}</div>
    </div>

    <div class="card">
        <strong>Summary</strong>
        <table>
            <tr><td>Passengers carried</td><td>{{ $totals['passengers'] }}</td></tr>
            <tr><td>Tickets issued</td><td>{{ $totals['tickets'] }}</td></tr>
            <tr><td>Cargo weight</td><td>{{ number_format($totals['weight'], 1) }} kg</td></tr>
            <tr><td>Total revenue</td><td>${{ number_format($totals['revenue'], 2) }}</td></tr>
        </table>
    </div>

    <div class="card">
        <strong>Per-Flight Breakdown</strong>
        <table>
            <thead>
                <tr><th>Flight</th><th>Journey</th><th>Passengers</th><th>Ticket Revenue</th><th>Cargo Weight</th><th>Shipment Revenue</th></tr>
            </thead>
            <tbody>
                @foreach($report as $row)
                    <tr>
                        <td>{{ $row['flight']->flight_number }}</td>
                        <td>{{ optional($row['flight']->departureAirport)->city ?? 'Unknown' }} → {{ optional($row['flight']->arrivalAirport)->city ?? 'Unknown' }}</td>
                        <td>{{ $row['passenger_count'] }}</td>
                        <td>${{ number_format($row['ticket_revenue'], 2) }}</td>
                        <td>{{ number_format($row['weight'], 1) }} kg</td>
                        <td>${{ number_format($row['shipment_revenue'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
