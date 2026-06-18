@extends('layouts.passenger')
@section('title', 'Dashboard')

@section('content')
    <div class="space-y-gutter">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-primary">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Here's what's happening with your upcoming travel.
            </p>
        </div>

        {{-- Upcoming Flights --}}
        <div class="space-y-base">
            <h3 class="font-headline-md text-headline-md text-on-surface">Upcoming Flights</h3>
            @forelse($activeTickets as $ticket)
                <div
                    class="bg-white rounded-xl border border-outline-variant/30 p-md flex flex-col md:flex-row md:items-center justify-between gap-base">
                    <div class="flex items-center gap-base">
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary">flight</span>
                        </div>
                        <div>
                            <div class="font-semibold text-on-surface">{{ $ticket->flight->flight_number }} —
                                {{ $ticket->flight->departureAirport->city }} → {{ $ticket->flight->arrivalAirport->city }}
                            </div>
                            <div class="text-xs text-on-surface-variant">
                                {{ $ticket->flight->departure_time->format('D, M d, Y · g:i A') }} · Gate
                                {{ $ticket->flight->gate ?? 'TBA' }} · Seat {{ $ticket->seat_no ?? 'Unassigned' }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700']; @endphp
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$ticket->status] ?? '' }}">{{ ucfirst($ticket->status) }}</span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-outline-variant/30 p-lg text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl block mb-2 opacity-30">flight</span>
                    No upcoming flights. <a href="{{ route('passenger.bookings.index') }}"
                        class="text-secondary underline">Book one now</a>.
                </div>
            @endforelse
        </div>

        {{-- Notifications --}}
        <div class="space-y-base">
            <h3 class="font-headline-md text-headline-md text-on-surface">Notifications</h3>
            <div class="bg-white rounded-xl border border-outline-variant/30 divide-y divide-outline-variant/20">
                @forelse($notifications as $note)
                    <div class="p-md flex items-start gap-3 {{ $note->is_read ? '' : 'bg-primary/5' }}">
                        @php $iconMap = ['pre_takeoff'=>'flight_takeoff','arrival'=>'flight_land','booking_confirmed'=>'check_circle','flight_delayed'=>'schedule','booking_cancelled'=>'cancel','general'=>'notifications']; @endphp
                        <span
                            class="material-symbols-outlined text-primary mt-0.5">{{ $iconMap[$note->type] ?? 'notifications' }}</span>
                        <div class="flex-1">
                            <div class="font-semibold text-sm text-on-surface">{{ $note->title }}</div>
                            <div class="text-xs text-on-surface-variant">{{ $note->message }}</div>
                            <div class="text-xs text-on-surface-variant/60 mt-1">{{ $note->sent_at?->diffForHumans() }}
                            </div>
                        </div>
                        @if (!$note->is_read)
                            <form method="POST" action="{{ route('passenger.notifications.read', $note) }}">
                                @csrf
                                <button type="submit" class="text-xs text-secondary underline">Mark read</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="p-md text-center text-on-surface-variant text-sm">No notifications yet</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
