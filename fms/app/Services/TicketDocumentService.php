<?php

namespace App\Services;

use App\Models\Ticket;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

class TicketDocumentService
{
    public function createTicketReceipt(Ticket $ticket): string
    {
        $ticket->loadMissing(['passenger', 'flight.departureAirport', 'flight.arrivalAirport', 'luggages', 'shipments']);

        $html = View::make('documents.ticket-receipt', ['ticket' => $ticket])->render();

        return $this->renderPdf($html);
    }

    public function createFlightReport(array $report, array $totals): string
    {
        $html = View::make('documents.flight-report', compact('report', 'totals'))->render();

        return $this->renderPdf($html);
    }

    protected function renderPdf(string $html): string
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
