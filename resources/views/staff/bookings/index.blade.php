@extends('layouts.staff')

@section('page_title', 'Manage Bookings')

@section('content')
    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('staff.bookings.create') }}" 
                class="bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-6 py-2.5 rounded-xl font-semibold hover:from-gold-400 hover:to-gold-500 transition-all text-sm">
                + New Booking
            </a>
        </div>
        
        <!-- Filters -->
        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, ref..."
                class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 w-56">
            <input type="date" name="date" value="{{ request('date') }}"
                class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500">
            <select name="status" class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500">
                <option value="" class="bg-slate-800">All Status</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }} class="bg-slate-800">Confirmed</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }} class="bg-slate-800">Cancelled</option>
            </select>
            <button type="submit" class="bg-white/10 text-white px-4 py-2 rounded-lg text-sm hover:bg-white/20 transition-all">Filter</button>
            @if(request()->hasAny(['search', 'date', 'status']))
                <a href="{{ route('staff.bookings.index') }}" class="text-gray-400 text-sm hover:text-white">Clear</a>
            @endif
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-slate-800 rounded-2xl border border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-900/50">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">
                            <a href="?sort=booking_reference&direction={{ request('direction') === 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except(['sort','direction'])) }}" class="hover:text-white">Ref</a>
                        </th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">
                            <a href="?sort=name&direction={{ request('direction') === 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except(['sort','direction'])) }}" class="hover:text-white">Name</a>
                        </th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Phone</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">
                            <a href="?sort=booking_date&direction={{ request('direction') === 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except(['sort','direction'])) }}" class="hover:text-white">Date</a>
                        </th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Pax</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Status</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-gold-400 font-mono text-xs">{{ $booking->booking_reference }}</td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ $booking->name }}</div>
                            <div class="text-gray-500 text-xs">{{ $booking->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->telephone }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->booking_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-white">{{ $booking->total_pax }}</span>
                            <span class="text-gray-500 text-xs">({{ $booking->adults }}A {{ $booking->children }}C {{ $booking->oku }}O)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-500/20 text-red-400' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('staff.bookings.edit', $booking) }}" class="text-blue-400 hover:text-blue-300 text-xs">Edit</a>
                                @if($booking->status !== 'cancelled')
                                    <form method="POST" action="{{ route('staff.bookings.cancel', $booking) }}" 
                                        onsubmit="return confirm('Cancel this booking?')">
                                        @csrf
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-white/10">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
@endsection
