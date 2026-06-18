@extends('layouts.admin')
@section('title', 'Passengers')
@section('page-title', 'Passenger Directory')

@section('content')
    <div class="bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="p-sm font-label-caps text-label-caps">Name</th>
                    <th class="p-sm font-label-caps text-label-caps">Contact</th>
                    <th class="p-sm font-label-caps text-label-caps">Tickets</th>
                    <th class="p-sm font-label-caps text-label-caps">Luggage Items</th>
                    <th class="p-sm font-label-caps text-label-caps">Status</th>
                </tr>
            </thead>
            <tbody class="font-data-tabular text-data-tabular">
                @forelse($passengers as $p)
                    <tr class="zebra-row">
                        <td class="p-sm border-b border-outline-variant/20 font-semibold">{{ $p->name }}</td>
                        <td class="p-sm border-b border-outline-variant/20">{{ $p->email }}<br><span
                                class="text-xs text-on-surface-variant">{{ $p->phone ?? '—' }}</span></td>
                        <td class="p-sm border-b border-outline-variant/20">{{ $p->tickets->count() }}</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            {{ $p->tickets->sum(fn($t) => $t->luggages->count()) }}</td>
                        <td class="p-sm border-b border-outline-variant/20">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $p->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-md text-center text-on-surface-variant">No passengers registered yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
