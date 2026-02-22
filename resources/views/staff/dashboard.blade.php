@extends('layouts.staff')

@section('page_title', 'Dashboard Overview')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-slate-800 rounded-2xl border border-white/10 p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Today's Bookings</span>
                <span class="text-2xl">📅</span>
            </div>
            <p class="text-3xl font-bold text-white">{{ $todayBookings->count() }}</p>
            <p class="text-emerald-400 text-sm mt-1">{{ $todayBookings->sum('total_pax') }} pax</p>
        </div>
        
        <div class="bg-slate-800 rounded-2xl border border-white/10 p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Monthly Bookings</span>
                <span class="text-2xl">📊</span>
            </div>
            <p class="text-3xl font-bold text-white">{{ $monthStats['total_bookings'] }}</p>
            <p class="text-gold-400 text-sm mt-1">{{ $monthStats['confirmed_bookings'] }} confirmed</p>
        </div>
        
        <div class="bg-slate-800 rounded-2xl border border-white/10 p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Total Pax (Month)</span>
                <span class="text-2xl">👥</span>
            </div>
            <p class="text-3xl font-bold text-white">{{ $monthStats['total_pax'] }}</p>
            <p class="text-blue-400 text-sm mt-1">across all bookings</p>
        </div>
        
        <div class="bg-slate-800 rounded-2xl border border-white/10 p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-400 text-sm">Capacity Used</span>
                <span class="text-2xl">📈</span>
            </div>
            <p class="text-3xl font-bold text-white">{{ $capacityStats['utilization_percentage'] }}%</p>
            <div class="mt-2 w-full bg-white/10 rounded-full h-2">
                <div class="bg-gradient-to-r from-emerald-500 to-gold-500 h-2 rounded-full" style="width: {{ min(100, $capacityStats['utilization_percentage']) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-slate-800 rounded-2xl border border-white/10 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
            <h2 class="font-semibold text-lg">Recent Bookings</h2>
            <a href="{{ route('staff.bookings.index') }}" class="text-gold-400 text-sm hover:text-gold-300">View All →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-750">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Reference</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Name</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Date</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Pax</th>
                        <th class="text-left px-6 py-3 text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-gold-400 font-mono text-xs">{{ $booking->booking_reference }}</td>
                        <td class="px-6 py-4 text-white">{{ $booking->name }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->booking_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->total_pax }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-500/20 text-red-400' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No bookings yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
