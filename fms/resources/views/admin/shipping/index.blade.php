@extends('layouts.admin')
@section('title', 'Shipping')
@section('page-title', 'Shipping & Cargo')

@section('content')
    <div x-data="{ showAddModal: false, editingShipment: null }">

        <div class="flex items-center justify-between mb-md">
            <p class="font-body-md text-body-md text-on-surface-variant">Only admins may register or alter shipments.
                Passengers can view shipments linked to their ticket (read-only).</p>
            <button @click="showAddModal = true"
                class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> Register Shipment
            </button>
        </div>

        <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-sm font-label-caps text-label-caps">Shipment #</th>
                        <th class="p-sm font-label-caps text-label-caps">Flight</th>
                        <th class="p-sm font-label-caps text-label-caps">Sender</th>
                        <th class="p-sm font-label-caps text-label-caps">Receiver</th>
                        <th class="p-sm font-label-caps text-label-caps">Weight</th>
                        <th class="p-sm font-label-caps text-label-caps">Fee</th>
                        <th class="p-sm font-label-caps text-label-caps">Status</th>
                        <th class="p-sm font-label-caps text-label-caps">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-data-tabular text-data-tabular">
                    @forelse($shipments as $s)
                        <tr class="zebra-row {{ $s->status === 'cancelled' ? 'opacity-60' : '' }}">
                            <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $s->shipment_no }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $s->flight->flight_number }}
                                ({{ $s->flight->departureAirport->code }}→{{ $s->flight->arrivalAirport->code }})</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $s->sender_name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $s->receiver_name }}</td>
                            <td class="p-sm border-b border-outline-variant/20">{{ $s->weight }} kg</td>
                            <td class="p-sm border-b border-outline-variant/20">${{ number_format($s->fee, 2) }}</td>
                            <td class="p-sm border-b border-outline-variant/20">
                                @php $statusColors = ['loaded'=>'bg-blue-100 text-blue-700','in_transit'=>'bg-purple-100 text-purple-700','delivered'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700']; @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$s->status] ?? '' }}">{{ ucfirst(str_replace('_', ' ', $s->status)) }}</span>
                            </td>
                            <td class="p-sm border-b border-outline-variant/20">
                                <div class="flex gap-1">
                                    <button @click="editingShipment = {{ $s->toJson() }}"
                                        class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    @if ($s->status !== 'cancelled')
                                        <form method="POST" action="{{ route('admin.shipping.destroy', $s) }}"
                                            onsubmit="return confirm('Cancel this shipment?')">
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
                            <td colspan="8" class="p-md text-center text-on-surface-variant">No shipments registered yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Shipment Modal --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg max-h-[90vh] overflow-y-auto"
                @click.outside="showAddModal = false">
                <h3 class="font-headline-md text-headline-md text-primary mb-md">Register Shipment</h3>
                <form method="POST" action="{{ route('admin.shipping.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Flight</label>
                        <select name="flight_id" required
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            <option value="">Select flight...</option>
                            @foreach ($flights as $f)
                                <option value="{{ $f->id }}">{{ $f->flight_number }} —
                                    {{ $f->departureAirport->city }} → {{ $f->arrivalAirport->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Link to Ticket (optional)</label>
                        <select name="ticket_id" class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                            <option value="">None (standalone cargo)</option>
                            @foreach ($tickets as $t)
                                <option value="{{ $t->id }}">{{ $t->ticket_no }} — {{ $t->passenger->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Sender Name</label>
                            <input type="text" name="sender_name" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Sender Phone</label>
                            <input type="text" name="sender_phone"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Receiver Name</label>
                            <input type="text" name="receiver_name" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Receiver Phone</label>
                            <input type="text" name="receiver_phone"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Description</label>
                        <input type="text" name="description" placeholder="4x Crates (Sensitive Components)"
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
                            <input type="number" name="fee" step="0.01" required
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Register
                            Shipment</button>
                        <button type="button" @click="showAddModal = false"
                            class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Shipment Modal --}}
        <div x-show="editingShipment" x-cloak
            class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="editingShipment = null">
                <template x-if="editingShipment">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-primary mb-md">Edit Shipment <span
                                x-text="editingShipment.shipment_no"></span></h3>
                        <form method="POST" :action="`/admin/shipping/${editingShipment.id}`" class="space-y-3">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Weight (kg)</label>
                                    <input type="number" name="weight" step="0.1" :value="editingShipment.weight"
                                        required class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase mb-1">Fee ($)</label>
                                    <input type="number" name="fee" step="0.01" :value="editingShipment.fee"
                                        required class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1">Status</label>
                                <select name="status" required
                                    class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                                    <option value="loaded" :selected="editingShipment.status === 'loaded'">Loaded</option>
                                    <option value="in_transit" :selected="editingShipment.status === 'in_transit'">In Transit
                                    </option>
                                    <option value="delivered" :selected="editingShipment.status === 'delivered'">Delivered
                                    </option>
                                    <option value="cancelled" :selected="editingShipment.status === 'cancelled'">Cancelled
                                    </option>
                                </select>
                            </div>
                            <div class="flex gap-2 pt-2">
                                <button type="submit"
                                    class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Save
                                    Changes</button>
                                <button type="button" @click="editingShipment = null"
                                    class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection
