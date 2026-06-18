@extends('layouts.passenger')
@section('title', 'Shipping')

@section('content')
<div>
    <h1 class="font-headline-lg text-headline-lg text-primary mb-1">My Shipments</h1>
    <p class="font-body-md text-body-md text-on-surface-variant mb-md">Shipments linked to your bookings are assigned by our team. This view is read-only.</p>

    <div class="space-y-base">
        @forelse($shipments as $s)
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex flex-col md:flex-row md:items-center justify-between gap-base">
            <div class="flex items-center gap-base">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary">local_shipping</span>
                </div>
                <div>
                    <div class="font-semibold text-on-surface">{{ $s->shipment_no }}</div>
                    <div class="text-xs text-on-surface-variant">{{ $s->description }}</div>
                    <div class="text-xs text-on-surface-variant">{{ $s->flight->flight_number }} · {{ $s->flight->departureAirport->city }} → {{ $s->flight->arrivalAirport->city }} · {{ $s->weight }} kg</div>
                </div>
            </div>
            <div>
                @php $statusColors = ['loaded'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-purple-100 text-purple-700','delivered'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700']; @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$s->status] ?? '' }}">{{ ucfirst(str_replace('_',' ', $s->status)) }}</span>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-outline-variant/30 p-lg text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">local_shipping</span>
            No shipments linked to your account yet.
        </div>
        @endforelse
    </div>
</div>
@endsection
