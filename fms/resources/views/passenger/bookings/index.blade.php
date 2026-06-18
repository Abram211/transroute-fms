@extends('layouts.passenger')
@section('title', 'My Bookings')

@section('content')
<div x-data="{ showBookModal: false }">
    <div class="flex items-center justify-between mb-md">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-primary">My Bookings</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">View, manage, and cancel your flight tickets.</p>
        </div>
        <button @click="showBookModal = true" class="bg-secondary-container text-on-secondary-container px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
            <span class="material-symbols-outlined text-base">add</span> Book Flight
        </button>
    </div>

    <div class="space-y-base">
        @forelse($tickets as $ticket)
        <div class="bg-white rounded-xl border border-outline-variant/30 p-md flex flex-col md:flex-row md:items-center justify-between gap-base">
            <div class="flex items-center gap-base">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary">confirmation_number</span>
                </div>
                <div>
                    <div class="font-semibold text-on-surface">{{ $ticket->ticket_no }} — {{ $ticket->flight->flight_number }}</div>
                    <div class="text-xs text-on-surface-variant">{{ $ticket->flight->departureAirport->city }} → {{ $ticket->flight->arrivalAirport->city }} · {{ $ticket->flight->departure_time->format('M d, Y g:i A') }}</div>
                    <div class="text-xs text-on-surface-variant">Seat {{ $ticket->seat_no ?? 'Unassigned' }} · ${{ number_format($ticket->fare, 2) }}</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700','no_show'=>'bg-orange-100 text-orange-700','completed'=>'bg-gray-100 text-gray-700']; @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$ticket->status] ?? '' }}">{{ ucfirst(str_replace('_',' ', $ticket->status)) }}</span>
                @if($ticket->isCancellable())
                <form method="POST" action="{{ route('passenger.bookings.cancel', $ticket) }}" onsubmit="return confirm('Cancel this booking?')">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-red-50 text-error rounded-lg text-xs font-semibold hover:bg-red-100">Cancel</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-outline-variant/30 p-lg text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">confirmation_number</span>
            You haven't booked any flights yet.
        </div>
        @endforelse
    </div>

    {{-- Book Flight Modal --}}
    <div x-show="showBookModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,31,60,0.5);backdrop-filter:blur(4px);">
        <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="showBookModal = false">
            <h3 class="font-headline-md text-headline-md text-primary mb-md">Book a Flight</h3>
            <form method="POST" action="{{ route('passenger.bookings.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Select Flight</label>
                    <select name="flight_id" required class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        <option value="">Choose a flight...</option>
                        @foreach($upcomingFlights as $f)
                        <option value="{{ $f->id }}" {{ $f->seats_available <= 0 ? 'disabled' : '' }}>
                            {{ $f->flight_number }} — {{ $f->departureAirport->city }} → {{ $f->arrivalAirport->city }} ({{ $f->departure_time->format('M d, g:i A') }}) — ${{ number_format($f->base_fare, 2) }} {{ $f->seats_available <= 0 ? '(FULL)' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase mb-1">Preferred Seat (optional)</label>
                    <input type="text" name="seat_no" placeholder="e.g. A5" class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                </div>
                <p class="text-xs text-on-surface-variant">Your booking will be submitted as "pending" until approved by an administrator.</p>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Submit Booking</button>
                    <button type="button" @click="showBookModal = false" class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
