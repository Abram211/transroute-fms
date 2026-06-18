@extends('layouts.admin')
@section('title', 'Schedule')
@section('page-title', 'Flight Schedule Manifest')

@section('content')
    <div x-data="{ showAddModal: false, editingFlight: null }">

        <div class="flex items-center justify-between mb-md">
            <p class="font-body-md text-body-md text-on-surface-variant">Manage active and cancelled flight schedules. This
                manifest also powers the public website schedule section.</p>
            <button @click="showAddModal = true"
                class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> Add Flight
            </button>
        </div>

        {{-- Active Schedule Manifest --}}
        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden mb-lg">
            <div class="p-md border-b border-outline-variant/30">
                <h3 class="font-headline-md text-headline-md text-primary">Active Schedule Manifest</h3>
                <p class="text-xs text-on-surface-variant">Rendered live on the public website's Schedule section.</p>
            </div>
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps">Flight #</th>
                        <th class="p-sm font-label-caps text-label-caps">Journey</th>
                        <th class="p-sm font-label-caps text-label-caps">Departure</th>
                        <th class="p-sm font-label-caps text-label-caps">Arrival</th>
                        <th class="p-sm font-label-caps text-label-caps">Gate</th>
                        <th class="p-sm font-label-caps text-label-caps">Seats</th>
                        <th class="p-sm font-label-caps text-label-caps">Status</th>
                        <th class="p-sm font-label-caps text-label-caps">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($activeFlights as $flight)
                        <tr class="zebra-row">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $flight->flight_number }}
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $flight->departureAirport->city }}
                                ({{ $flight->departureAirport->code }}) → {{ $flight->arrivalAirport->city }}
                                ({{ $flight->arrivalAirport->code }})</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->departure_time->format('M d, Y g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->arrival_time->format('M d, Y g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $flight->gate ?? '—' }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->seats_available }}/{{ $flight->capacity }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                @php $statusColors = ['scheduled'=>'bg-blue-100 text-blue-700','boarding'=>'bg-green-100 text-green-700','delayed'=>'bg-yellow-100 text-yellow-700','departed'=>'bg-purple-100 text-purple-700','arrived'=>'bg-gray-100 text-gray-700']; @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$flight->status] ?? '' }}">{{ ucfirst($flight->status) }}</span>
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <div class="flex items-center gap-1">
                                    <button @click="editingFlight = {{ $flight->toJson() }}"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.flights.cancel', $flight) }}"
                                        onsubmit="return confirm('Cancel flight {{ $flight->flight_number }}? Pending/confirmed tickets will be auto-cancelled. Record stays in history.')">
                                        @csrf
                                        <button type="submit"
                                            class="p-1.5 text-on-surface-variant hover:text-error hover:bg-red-50 rounded-lg">
                                            <span class="material-symbols-outlined text-base">cancel</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-md text-center text-on-surface-variant">No active flights scheduled
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Cancelled Flights (kept visible, not deleted) --}}
        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
            <div class="p-md border-b border-outline-variant/30">
                <h3 class="font-headline-md text-headline-md text-on-surface-variant">Cancelled Flights</h3>
                <p class="text-xs text-on-surface-variant">Retained for record-keeping — not deleted.</p>
            </div>
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Flight #</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Journey</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Was Scheduled</th>
                        <th class="p-sm font-label-caps text-label-caps text-on-surface-variant">Status</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($cancelledFlights as $flight)
                        <tr class="zebra-row opacity-70">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $flight->flight_number }}
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $flight->departureAirport->city }} →
                                {{ $flight->arrivalAirport->city }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                {{ $flight->departure_time->format('M d, Y g:i A') }}</td>
                            <td class="p-sm border-b border-outline-variant/20"><span
                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Cancelled</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-md text-center text-on-surface-variant">No cancelled flights</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Flight Modal --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="showAddModal = false">
                <h3 class="font-headline-md text-headline-md text-primary mb-md">Add Flight Schedule</h3>
                <form method="POST" action="{{ route('admin.flights.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Flight Number</label>
                        <input type="text" name="flight_number" required placeholder="e.g. TR-1004"
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">From Airport</label>
                            <select name="departure_airport_id" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                <option value="">Select...</option>
                                @foreach ($airports as $a)
                                    <option value="{{ $a->id }}">{{ $a->city }} ({{ $a->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">To Airport</label>
                            <select name="arrival_airport_id" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                <option value="">Select...</option>
                                @foreach ($airports as $a)
                                    <option value="{{ $a->id }}">{{ $a->city }} ({{ $a->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Departure Time</label>
                            <input type="datetime-local" name="departure_time" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Arrival Time</label>
                            <input type="datetime-local" name="arrival_time" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Gate</label>
                            <input type="text" name="gate" placeholder="A1"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Capacity</label>
                            <input type="number" name="capacity" value="150" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Base Fare ($)</label>
                            <input type="number" name="base_fare" value="120" step="0.01" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Add
                            Flight</button>
                        <button type="button" @click="showAddModal = false"
                            class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Flight Modal --}}
        <div x-show="editingFlight" x-cloak
            class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="editingFlight = null"
                x-show="editingFlight" x-bind:key="editingFlight?.id">
                <template x-if="editingFlight">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-md">Edit Flight <span
                                x-text="editingFlight.flight_number"></span></h3>
                        <form method="POST" :action="`/admin/flights/${editingFlight.id}`" class="space-y-3">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Flight Number</label>
                                <input type="text" name="flight_number" :value="editingFlight.flight_number" required
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">From Airport</label>
                                    <select name="departure_airport_id" required
                                        class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                        @foreach ($airports as $a)
                                            <option value="{{ $a->id }}"
                                                :selected="editingFlight.departure_airport_id === {{ $a->id }}">
                                                {{ $a->city }} ({{ $a->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">To Airport</label>
                                    <select name="arrival_airport_id" required
                                        class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                        @foreach ($airports as $a)
                                            <option value="{{ $a->id }}"
                                                :selected="editingFlight.arrival_airport_id === {{ $a->id }}">
                                                {{ $a->city }} ({{ $a->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Departure Time</label>
                                    <input type="datetime-local" name="departure_time"
                                        :value="editingFlight.departure_time?.slice(0, 16)" required
                                        class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Arrival Time</label>
                                    <input type="datetime-local" name="arrival_time"
                                        :value="editingFlight.arrival_time?.slice(0, 16)" required
                                        class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Status</label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                    <option value="scheduled" :selected="editingFlight.status === 'scheduled'">Scheduled
                                    </option>
                                    <option value="boarding" :selected="editingFlight.status === 'boarding'">Boarding
                                    </option>
                                    <option value="delayed" :selected="editingFlight.status === 'delayed'">Delayed</option>
                                    <option value="departed" :selected="editingFlight.status === 'departed'">Departed
                                    </option>
                                    <option value="arrived" :selected="editingFlight.status === 'arrived'">Arrived</option>
                                </select>
                                <p class="text-xs text-on-surface-variant mt-1">Setting "Delayed" automatically notifies
                                    all booked passengers.</p>
                            </div>
                            <div class="flex gap-2 pt-2">
                                <button type="submit"
                                    class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Save
                                    Changes</button>
                                <button type="button" @click="editingFlight = null"
                                    class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection
