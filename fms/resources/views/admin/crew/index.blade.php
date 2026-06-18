@extends('layouts.admin')
@section('title', 'Crew')
@section('page-title', 'Crew Management')

@section('content')
    <div x-data="{ showAddModal: false }">
        <div class="flex items-center justify-between mb-md">
            <p class="font-body-md text-body-md text-on-surface-variant">Manage pilots, logistics leads and ground crew.</p>
            <button @click="showAddModal = true"
                class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> Add Crew Member
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            @forelse($crew as $member)
                <div class="bg-white rounded-xl border border-outline-variant/30 p-md">
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-on-surface">{{ $member->name }}</div>
                            <div class="text-xs text-on-surface-variant">{{ $member->role }}</div>
                        </div>
                    </div>
                    <div class="text-xs text-on-surface-variant space-y-1">
                        @if ($member->phone)
                            <div><span class="material-symbols-outlined text-xs align-middle">call</span>
                                {{ $member->phone }}</div>
                        @endif
                        @if ($member->email)
                            <div><span class="material-symbols-outlined text-xs align-middle">mail</span>
                                {{ $member->email }}</div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-outline-variant/20">
                        <span
                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $member->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($member->status) }}</span>
                        @if ($member->status === 'active')
                            <form method="POST" action="{{ route('admin.crew.destroy', $member) }}"
                                onsubmit="return confirm('Set this crew member inactive?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-error hover:underline">Set Inactive</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-on-surface-variant py-12">No crew members yet</div>
            @endforelse
        </div>

        <div x-show="showAddModal" x-cloak class="fixed inset-0 modal-backdrop z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-lg" @click.outside="showAddModal = false">
                <h3 class="font-headline-md text-headline-md text-primary mb-md">Add Crew Member</h3>
                <form method="POST" action="{{ route('admin.crew.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Name</label>
                        <input type="text" name="name" required
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Role</label>
                        <input type="text" name="role" required placeholder="Pilot, Logistics Lead..."
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Phone</label>
                            <input type="text" name="phone"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1">Email</label>
                            <input type="email" name="email"
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase mb-1">Salary ($)</label>
                        <input type="number" name="salary" step="0.01"
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg text-sm">
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-label-caps">Add
                            Member</button>
                        <button type="button" @click="showAddModal = false"
                            class="bg-surface-container px-4 py-2 rounded-lg font-label-caps text-label-caps">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
