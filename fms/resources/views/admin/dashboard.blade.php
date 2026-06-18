@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex items-center gap-base">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary">groups</span>
            </div>
            <div>
                <div class="text-2xl font-bold text-on-surface">{{ number_format($stats['total_passengers']) }}</div>
                <div class="text-xs text-on-surface-variant font-label-caps uppercase">Passengers</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex items-center gap-base">
            <div class="w-12 h-12 rounded-lg bg-secondary-container/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-secondary">payments</span>
            </div>
            <div>
                <div class="text-2xl font-bold text-on-surface">${{ number_format($stats['total_revenue'], 2) }}</div>
                <div class="text-xs text-on-surface-variant font-label-caps uppercase">Total Revenue</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex items-center gap-base">
            <div class="w-12 h-12 rounded-lg bg-tertiary/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-tertiary">scale</span>
            </div>
            <div>
                <div class="text-2xl font-bold text-on-surface">{{ number_format($stats['cargo_weight'], 0) }} kg</div>
                <div class="text-xs text-on-surface-variant font-label-caps uppercase">Cargo Weight</div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex items-center gap-base">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary">flight</span>
            </div>
            <div>
                <div class="text-2xl font-bold text-on-surface">{{ $stats['active_flights'] }}</div>
                <div class="text-xs text-on-surface-variant font-label-caps uppercase">Active Flights</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
        <div class="p-md border-b border-outline-variant/30 flex items-center justify-between">
            <h3 class="font-headline-md text-headline-md text-primary">Recent Flight Activity</h3>
            <a href="{{ route('admin.flights.index') }}"
                class="font-label-caps text-label-caps text-secondary hover:underline">View Schedule →</a>
        </div>
        <table class="w-full text-left">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Journey</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Departure</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Gate</th>
                    <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Status</th>
                </tr>
            </thead>
            <tbody class="font-data-tabular text-data-tabular">
                @forelse($recentFlights as $flight)
                    <tr class="zebra-row">
                        <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $flight->flight_number }}</td>
                        <td class="p-sm border-b border-outline-variant/20">{{ $flight->departureAirport->city }} →
                            {{ $flight->arrivalAirport->city }}</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            {{ $flight->departure_time->format('M d, g:i A') }}</td>
                        <td class="p-sm border-b border-outline-variant/20">{{ $flight->gate ?? '—' }}</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            @php $statusColors = ['scheduled'=>'bg-blue-100 text-blue-700','boarding'=>'bg-green-100 text-green-700','delayed'=>'bg-yellow-100 text-yellow-700','departed'=>'bg-purple-100 text-purple-700','arrived'=>'bg-gray-100 text-gray-700','cancelled'=>'bg-red-100 text-red-700']; @endphp
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$flight->status] ?? '' }}">{{ ucfirst($flight->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-md text-center text-on-surface-variant">No flights yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
