@extends('layouts.admin')
@section('title', 'Booking')
@section('page-title', 'Booking Management')

@section('content')
    <div x-data="{ showAddModal: false }">

        <div class="flex items-center justify-between mb-md">
            <p class="font-body-md text-body-md text-on-surface-variant">Approve pending requests, create new bookings, or
                cancel tickets for passengers who didn't turn up.</p>
            <button @click="showAddModal = true"
                class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> New Booking
            </button>
        </div>

        {{-- Pending Approval --}}
        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden mb-lg">
            <div class="p-md border-b border-outline-variant/30">
                <h3 class="font-headline-md text-headline-md text-primary">Pending Approval</h3>
            </div>
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Ticket #</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Passenger</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Seat</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Fare</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($pendingTickets as $ticket)
                        <tr class="zebra-row">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $ticket->ticket_no }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->passenger->name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->flight->flight_number }} —
                                {{ $ticket->flight->departureAirport->city }} → {{ $ticket->flight->arrivalAirport->city }}
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->seat_no ?? '—' }}</td>
                            <td class="p-sm border-b border-outline-variant/20">${{ number_format($ticket->fare, 2) }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('admin.bookings.receipt', $ticket) }}"
                                        class="px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold">PDF</a>
                                    <form method="POST" action="{{ route('admin.bookings.approve', $ticket) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bookings.cancel', $ticket) }}"
                                        onsubmit="return confirm('Mark this ticket cancelled (no-show)?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">Cancel</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-md text-center text-on-surface-variant">No pending bookings</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Confirmed --}}
        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden mb-lg">
            <div class="p-md border-b border-outline-variant/30">
                <h3 class="font-headline-md text-headline-md text-primary">Confirmed Bookings</h3>
            </div>
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Ticket #</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Passenger</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Seat</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Departure</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($confirmedTickets as $ticket)
                        <tr class="zebra-row">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $ticket->ticket_no }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->passenger->name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->flight->flight_number }} —
                                {{ $ticket->flight->departureAirport->city }} →
                                {{ $ticket->flight->arrivalAirport->city }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->seat_no ?? '—' }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $ticket->flight->departure_time->format('M d, g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <div class="flex gap-1 flex-wrap">
                                    <a href="{{ route('admin.bookings.receipt', $ticket) }}"
                                        class="px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold">PDF</a>
                                    <form method="POST" action="{{ route('admin.bookings.cancel', $ticket) }}"
                                        onsubmit="return confirm('Mark this ticket cancelled (no-show)? Record is retained, not deleted.')">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">No-Show /
                                            Cancel</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-md text-center text-on-surface-variant">No confirmed bookings</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Cancelled / No-show (kept visible) --}}
        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
            <div class="p-md border-b border-outline-variant/30">
                <h3 class="font-headline-md text-headline-md text-on-surface-variant">Cancelled / No-Show Tickets</h3>
                <p class="text-xs text-on-surface-variant">Retained for record-keeping — not deleted.</p>
            </div>
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Ticket #</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Passenger</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Status</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($cancelledTickets as $ticket)
                        <tr class="zebra-row opacity-70">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $ticket->ticket_no }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->passenger->name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $ticket->flight->flight_number }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $ticket->status === 'no_show' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $ticket->status === 'no_show' ? 'No-Show' : 'Cancelled' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-md text-center text-on-surface-variant">No cancelled tickets</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Booking Modal --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="showAddModal = false">
                <h3 class="font-headline-md text-headline-md text-primary mb-md">Create Booking</h3>
                <form method="POST" action="{{ route('admin.bookings.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Passenger</label>
                        <select name="user_id" required
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            <option value="">Select passenger...</option>
                            @foreach ($passengers as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Flight</label>
                        <select name="flight_id" required
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            <option value="">Select flight...</option>
                            @foreach ($flights as $f)
                                <option value="{{ $f->id }}">{{ $f->flight_number }} —
                                    {{ $f->departureAirport->city }} → {{ $f->arrivalAirport->city }}
                                    ({{ $f->departure_time->format('M d, g:i A') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Seat No.</label>
                            <input type="text" name="seat_no" placeholder="A1"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Fare ($)</label>
                            <input type="number" name="fare" value="120" step="0.01" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Create
                            & Confirm</button>
                        <button type="button" @click="showAddModal = false"
                            class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
