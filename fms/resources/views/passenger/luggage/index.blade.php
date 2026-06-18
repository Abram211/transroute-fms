@extends('layouts.passenger')
@section('title', 'Luggage')

@section('content')
<div>
    <h1 class="font-headline-lg text-headline-lg text-primary mb-1">My Luggage</h1>
    <p class="font-body-md text-body-md text-on-surface-variant mb-md">Luggage is assigned by our team. You can confirm pickup once it has arrived.</p>

    <div class="space-y-base">
        @forelse($luggages as $lug)
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex flex-col md:flex-row md:items-center justify-between gap-base">
            <div class="flex items-center gap-base">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary">luggage</span>
                </div>
                <div>
                    <div class="font-semibold text-on-surface">{{ $lug->luggage_code }} — {{ $lug->item_type }}</div>
                    <div class="text-xs text-on-surface-variant">{{ $lug->description }}</div>
                    <div class="text-xs text-on-surface-variant">{{ $lug->ticket->flight->flight_number }} · {{ $lug->ticket->flight->departureAirport->city }} → {{ $lug->ticket->flight->arrivalAirport->city }} · {{ $lug->weight }} kg</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','checked_in'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-purple-100 text-purple-700','picked'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700']; @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$lug->status] ?? '' }}">{{ ucfirst(str_replace('_',' ', $lug->status)) }}</span>
                @if($lug->status === 'in_transit')
                <form method="POST" action="{{ route('passenger.luggage.status', $lug) }}">
                    @csrf
                    <input type="hidden" name="status" value="picked">
                    <button type="submit" class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-100">Confirm Pickup</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-outline-variant/30 p-lg text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">luggage</span>
            No luggage records yet.
        </div>
        @endforelse
    </div>
</div>
@endsection
