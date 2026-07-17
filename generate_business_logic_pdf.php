<?php
require 'fms/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$html = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TransRoute Business Logic</title>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; color: #1f2937; line-height: 1.5; font-size: 12px; }
    h1 { font-size: 24px; color: #0f172a; margin-bottom: 8px; }
    h2 { font-size: 16px; color: #1d4ed8; margin-top: 18px; margin-bottom: 6px; }
    h3 { font-size: 13px; color: #111827; margin-top: 12px; margin-bottom: 4px; }
    .box { border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px; margin-bottom: 10px; background: #f9fafb; }
    ul { margin: 4px 0 8px 18px; padding: 0; }
    li { margin-bottom: 3px; }
    .small { font-size: 10px; color: #6b7280; }
    table { border-collapse: collapse; width: 100%; margin-top: 6px; }
    th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; font-size: 11px; }
    th { background: #eef2ff; }
  </style>
</head>
<body>
  <h1>TransRoute Flight Management System</h1>
  <div class="small">Business Logic and Process Overview</div>

  <div class="box">
    <h2>1. Executive Summary</h2>
    <p>The TransRoute Flight Management System manages passenger bookings, linked travel items, reporting, receipts, and notifications. The core business object is the ticket, which connects passengers, flights, luggage, shipments, and operational events.</p>
  </div>

  <div class="box">
    <h2>2. Core Business Entities</h2>
    <ul>
      <li><strong>User:</strong> Passenger or admin</li>
      <li><strong>Flight:</strong> Flight schedule, route, capacity, fare, status</li>
      <li><strong>Ticket:</strong> Passenger booking for a flight</li>
      <li><strong>Luggage:</strong> Travel item linked to a ticket</li>
      <li><strong>Shipment:</strong> Cargo or delivery item linked to a ticket or flight</li>
      <li><strong>Notification:</strong> System-generated update</li>
    </ul>
  </div>

  <div class="box">
    <h2>3. Key Business Rules</h2>
    <ul>
      <li>A ticket can be canceled only if it is pending or confirmed and the flight has not departed.</li>
      <li>Seat availability is calculated from flight capacity minus booked seats.</li>
      <li>Reports are generated from real database records for tickets and shipments.</li>
      <li>Receipts include booking details, flight information, and linked luggage or shipments.</li>
      <li>Notifications are created for booking confirmation, cancellation, delay, pre-takeoff, and arrival events.</li>
    </ul>
  </div>

  <div class="box">
    <h2>4. Main Business Workflows</h2>
    <h3>Booking Workflow</h3>
    <ol>
      <li>Passenger submits a booking request.</li>
      <li>The system creates a ticket record.</li>
      <li>Admin approves or cancels the booking.</li>
      <li>Luggage and shipment items may be linked to the ticket.</li>
      <li>A receipt PDF is generated for the booking.</li>
    </ol>

    <h3>Reporting Workflow</h3>
    <ol>
      <li>Admin opens the reporting module.</li>
      <li>The system queries ticket and shipment data for the selected period.</li>
      <li>Totals and breakdowns are calculated.</li>
      <li>The report is displayed and can be exported as PDF.</li>
    </ol>
  </div>

  <div class="box">
    <h2>5. Use Cases</h2>
    <table>
      <tr><th>Passenger</th><th>Admin</th></tr>
      <tr>
        <td>Register and log in<br/>View flights<br/>Book a flight<br/>View bookings<br/>Cancel a booking<br/>Download receipt PDF</td>
        <td>Manage flights<br/>Approve/cancel bookings<br/>Manage luggage and shipments<br/>Review reports<br/>Export reports as PDF</td>
      </tr>
    </table>
  </div>

  <div class="box">
    <h2>6. Entity Relationships</h2>
    <ul>
      <li>One User can have many Tickets</li>
      <li>One Flight can have many Tickets</li>
      <li>One Ticket can have many Luggage items</li>
      <li>One Ticket can have many Shipments</li>
      <li>One Flight can have many Shipments</li>
      <li>One Ticket can have many Notifications</li>
    </ul>
  </div>

  <div class="box">
    <h2>7. Implementation Areas</h2>
    <ul>
      <li>Booking controllers</li>
      <li>Reporting controller</li>
      <li>Ticket and flight model logic</li>
      <li>Notification service</li>
      <li>PDF document service</li>
    </ul>
  </div>

  <div class="box">
    <h2>8. Conclusion</h2>
    <p>The business logic of the TransRoute system is centered on the ticket as the primary transaction object. From that booking record, the system supports approvals, linked travel items, receipts, reports, and passenger notifications.</p>
  </div>
</body>
</html>
HTML;

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$output = $dompdf->output();
file_put_contents('transroute-business-logic.pdf', $output);
echo "PDF created: transroute-business-logic.pdf\n";
