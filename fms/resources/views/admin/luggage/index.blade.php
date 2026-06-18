@extends('layouts.admin')
@section('title', 'Luggage')
@section('page-title', 'Luggage Management')

@section('content')
    <div x-data="{ showAddModal: false, editingLuggage: null }">

        <div class="flex items-center justify-between mb-md">
            <p class="font-body-md text-body-md text-on-surface-variant">Only admins can add or alter luggage records.
                Passengers may view and confirm pickup status.</p>
            <button @click="showAddModal = true"
                class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> Add Luggage
            </button>
        </div>

        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps">Code</th>
                        <th class="p-sm font-label-caps text-label-caps">Passenger</th>
                        <th class="p-sm font-label-caps text-label-caps">Flight</th>
                        <th class="p-sm font-label-caps text-label-caps">Item Type</th>
                        <th class="p-sm font-label-caps text-label-caps">Weight</th>
                        <th class="p-sm font-label-caps text-label-caps">Fee</th>
                        <th class="p-sm font-label-caps text-label-caps">Status</th>
                        <th class="p-sm font-label-caps text-label-caps">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($luggages as $lug)
                        <tr class="zebra-row {{ $lug->status === 'cancelled' ? 'opacity-60' : '' }}">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $lug->luggage_code }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $lug->ticket->passenger->name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $lug->ticket->flight->flight_number }}
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $lug->item_type }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $lug->weight }} kg</td>
                            <td class="p-sm border-b border-outline-variant/20">${{ number_format($lug->fee, 2) }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','checked_in'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-purple-100 text-purple-700','picked'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700']; @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$lug->status] ?? '' }}">{{ ucfirst(str_replace('_', ' ', $lug->status)) }}</span>
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <div class="flex gap-1">
                                    <button @click="editingLuggage = {{ $lug->toJson() }}"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    @if ($lug->status !== 'cancelled')
                                        <form method="POST" action="{{ route('admin.luggage.destroy', $lug) }}"
                                            onsubmit="return confirm('Cancel this luggage entry?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-on-surface-variant hover:text-error hover:bg-red-50 rounded-lg">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-md text-center text-on-surface-variant">No luggage records yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Luggage Modal --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="showAddModal = false">
                <h3 class="font-headline-md text-headline-md text-primary mb-md">Add Luggage</h3>
                <form method="POST" action="{{ route('admin.luggage.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Ticket / Passenger</label>
                        <select name="ticket_id" required
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            <option value="">Select ticket...</option>
                            @foreach ($tickets as $t)
                                <option value="{{ $t->id }}">{{ $t->ticket_no }} — {{ $t->passenger->name }}
                                    ({{ $t->flight->flight_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Item Type</label>
                        <input type="text" name="item_type" required placeholder="Suitcase, Backpack, Fragile..."
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Description</label>
                        <input type="text" name="description" placeholder="Large blue hardshell"
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Weight (kg)</label>
                            <input type="number" name="weight" step="0.1" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Fee ($)</label>
                            <input type="number" name="fee" step="0.01" value="0" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Add
                            Luggage</button>
                        <button type="button" @click="showAddModal = false"
                            class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Luggage Modal --}}
        <div x-show="editingLuggage" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="editingLuggage = null">
                <template x-if="editingLuggage">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-md">Edit Luggage <span
                                x-text="editingLuggage.luggage_code"></span></h3>
                        <form method="POST" :action="`/admin/luggage/${editingLuggage.id}`" class="space-y-3">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Item Type</label>
                                <input type="text" name="item_type" :value="editingLuggage.item_type" required
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Description</label>
                                <input type="text" name="description" :value="editingLuggage.description"
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Weight (kg)</label>
                                    <input type="number" name="weight" step="0.1" :value="editingLuggage.weight"
                                        required class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Fee ($)</label>
                                    <input type="number" name="fee" step="0.01" :value="editingLuggage.fee"
                                        required class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Status</label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                    <option value="pending" :selected="editingLuggage.status === 'pending'">Pending</option>
                                    <option value="checked_in" :selected="editingLuggage.status === 'checked_in'">Checked In
                                    </option>
                                    <option value="in_transit" :selected="editingLuggage.status === 'in_transit'">In Transit
                                    </option>
                                    <option value="picked" :selected="editingLuggage.status === 'picked'">Picked Up</option>
                                    <option value="cancelled" :selected="editingLuggage.status === 'cancelled'">Cancelled
                                    </option>
                                </select>
                            </div>
                            <div class="flex gap-2 pt-2">
                                <button type="submit"
                                    class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Save
                                    Changes</button>
                                <button type="button" @click="editingLuggage = null"
                                    class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection
