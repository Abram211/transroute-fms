@extends('layouts.admin')
@section('title', 'Reports')
@section('page-title', 'Flight Reports')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-md mb-lg">
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md">
            <div class="text-2xl font-bold text-on-surface">{{ number_format($totals['passengers']) }}</div>
            <div class="text-xs text-on-surface-variant font-label-caps uppercase">Total Passengers Carried</div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md">
            <div class="text-2xl font-bold text-on-surface">{{ number_format($totals['tickets']) }}</div>
            <div class="text-xs text-on-surface-variant font-label-caps uppercase">Tickets Issued</div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md">
            <div class="text-2xl font-bold text-on-surface">{{ number_format($totals['weight'], 0) }} kg</div>
            <div class="text-xs text-on-surface-variant font-label-caps uppercase">Cargo Weight Shipped</div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md">
            <div class="text-2xl font-bold text-on-surface">${{ number_format($totals['revenue'], 2) }}</div>
            <div class="text-xs text-on-surface-variant font-label-caps uppercase">Total Revenue</div>
        </div>
    </div>

    <div class="flex justify-end mb-md">
        <a href="{{ route('admin.reports.download') }}"
            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
            <span class="material-symbols-outlined text-base">download</span> Download PDF Report
        </a>
    </div>

    <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
        <div class="p-md border-b border-outline-variant/30">
            <h3 class="font-headline-md text-headline-md text-primary">Per-Flight Breakdown</h3>
        </div>
        <table class="w-full text-left">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Journey</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Passengers</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Ticket Revenue</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Cargo Weight</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Shipment Revenue</th>
                </tr>
            </thead>
            <tbody class="font-data-tabular text-data-tabular">
                @forelse($report as $row)
                    <tr class="zebra-row">
                        <td class="p-sm border-b border-outline-variant/20 font-semibold">
                            {{ $row['flight']->flight_number }}</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            {{ optional($row['flight']->departureAirport)->city ?? 'Unknown' }} →
                            {{ optional($row['flight']->arrivalAirport)->city ?? 'Unknown' }}</td>
                        <td class="p-sm border-b border-outline-variant/20">{{ $row['passenger_count'] }}</td>
                        <td class="p-sm border-b border-outline-variant/20">${{ number_format($row['ticket_revenue'], 2) }}
                        </td>
                        <td class="p-sm border-b border-outline-variant/20">{{ number_format($row['weight'], 1) }} kg</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            ${{ number_format($row['shipment_revenue'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-md text-center text-on-surface-variant">No flight data yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
