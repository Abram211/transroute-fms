@extends('layouts.passenger')
@section('title', 'Schedule')

@section('content')
    <div>
        <h1 class="font-headline-lg text-headline-lg text-primary mb-1">Flight Schedule</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mb-md">Active flight schedule manifest, updated live by
            our operations team.</p>

        <div class="bg-white rounded-xl overflow-hidden border border-outline-variant/30">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps">Flight #</th>
                        <th class="p-sm font-label-caps text-label-caps">Journey</th>
                        <th class="p-sm font-label-caps text-label-caps">Departure</th>
                        <th class="p-sm font-label-caps text-label-caps">Arrival</th>
                        <th class="p-sm font-label-caps text-label-caps">Gate</th>
                        <th class="p-sm font-label-caps text-label-caps">Status</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($flights as $flight)
                        <tr class="zebra-row">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $flight->flight_number }}
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $flight->departureAirport->city }}
                                ({{ $flight->departureAirport->code }}) → {{ $flight->arrivalAirport->city }}
                                ({{ $flight->arrivalAirport->code }})</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->departure_time->format('M d, g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->arrival_time->format('M d, g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $flight->gate ?? '—' }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                @php $statusColors = ['scheduled'=>'bg-blue-100 text-blue-700','boarding'=>'bg-green-100 text-green-700','delayed'=>'bg-yellow-100 text-yellow-700','departed'=>'bg-purple-100 text-purple-700','arrived'=>'bg-gray-100 text-gray-700']; @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$flight->status] ?? '' }}">{{ ucfirst($flight->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-md text-center text-on-surface-variant">No active schedules at this
                                time</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
