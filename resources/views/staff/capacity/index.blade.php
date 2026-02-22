@extends('layouts.staff')

@section('page_title', 'Capacity Management')

@section('content')
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-6 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Set Capacity Form -->
    <div class="bg-slate-800 rounded-2xl border border-white/10 p-6 mb-6" x-data="{ mode: 'single' }">
        <h2 class="font-semibold mb-4">Set Capacity</h2>

        <!-- Mode Toggle -->
        <div class="flex gap-2 mb-4">
            <button type="button" @click="mode = 'single'"
                :class="mode === 'single' ? 'bg-gold-500 text-gray-900' : 'bg-white/10 text-gray-400'" 
                class="px-4 py-1.5 rounded-lg text-xs font-medium transition-all">Single Date</button>
            <button type="button" @click="mode = 'range'"
                :class="mode === 'range' ? 'bg-gold-500 text-gray-900' : 'bg-white/10 text-gray-400'"
                class="px-4 py-1.5 rounded-lg text-xs font-medium transition-all">Date Range</button>
        </div>

        <form method="POST" action="{{ route('staff.capacity.store') }}" class="flex flex-wrap gap-4 items-end">
            @csrf

            <!-- Single Date -->
            <div x-show="mode === 'single'">
                <label class="block text-gray-400 text-xs mb-1">Date *</label>
                <input type="date" name="date" value="{{ old('date') }}"
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500">
            </div>

            <!-- Date Range -->
            <div x-show="mode === 'range'">
                <label class="block text-gray-400 text-xs mb-1">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500">
            </div>
            <div x-show="mode === 'range'">
                <label class="block text-gray-400 text-xs mb-1">End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500">
            </div>

            <div>
                <label class="block text-gray-400 text-xs mb-1">Max Capacity *</label>
                <input type="number" name="max_capacity" value="{{ old('max_capacity', 100) }}" min="1" max="1000" required
                    class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold-500 w-28">
            </div>
            <button type="submit"
                class="bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-6 py-2 rounded-lg font-semibold text-sm hover:from-gold-400 hover:to-gold-500 transition-all">
                Set Capacity
            </button>
        </form>
    </div>

    <!-- Month Navigation -->
    <div class="flex items-center justify-between mb-4">
        @php
            $prevMonth = $month - 1;
            $prevYear = $year;
            if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
            $nextMonth = $month + 1;
            $nextYear = $year;
            if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
        @endphp
        <a href="?year={{ $prevYear }}&month={{ $prevMonth }}" class="text-gray-400 hover:text-white text-sm">← Previous</a>
        <h3 class="text-white font-semibold">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</h3>
        <a href="?year={{ $nextYear }}&month={{ $nextMonth }}" class="text-gray-400 hover:text-white text-sm">Next →</a>
    </div>

    <!-- Capacity Calendar -->
    <div class="bg-slate-800 rounded-2xl border border-white/10 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
            <h2 class="font-semibold">Capacity Overview</h2>
            <div class="flex gap-3 text-xs">
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-emerald-500 rounded-full"></span> Available</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-yellow-500 rounded-full"></span> Nearly Full</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-red-500 rounded-full"></span> Full</span>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-1 p-6">
            @php $daysOfWeek = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']; @endphp
            @foreach($daysOfWeek as $day)
                <div class="text-center text-gray-500 text-xs font-medium py-2">{{ $day }}</div>
            @endforeach

            @if(count($capacities) > 0)
                @php
                    $firstDate = \Carbon\Carbon::parse($capacities[0]['date']);
                    $dayOfWeek = $firstDate->dayOfWeekIso; // 1=Mon, 7=Sun
                @endphp
                @for($i = 1; $i < $dayOfWeek; $i++)
                    <div></div>
                @endfor
            @endif

            @forelse($capacities as $cap)
                @php
                    $percentage = $cap['max_capacity'] > 0 ? ($cap['current_bookings'] / $cap['max_capacity']) * 100 : 0;
                    $isFull = $cap['current_bookings'] >= $cap['max_capacity'];
                    $bgColor = $isFull ? 'bg-red-500/20 border-red-500/30' : ($percentage >= 75 ? 'bg-yellow-500/20 border-yellow-500/30' : 'bg-emerald-500/20 border-emerald-500/30');
                    $textColor = $isFull ? 'text-red-400' : ($percentage >= 75 ? 'text-yellow-400' : 'text-emerald-400');
                    $barColor = $isFull ? 'bg-red-500' : ($percentage >= 75 ? 'bg-yellow-500' : 'bg-emerald-500');
                @endphp
                <div class="rounded-xl border {{ $bgColor }} p-3 text-center hover:bg-white/10 transition-all">
                    <div class="text-white text-sm font-semibold">{{ \Carbon\Carbon::parse($cap['date'])->format('d') }}</div>
                    <div class="text-xs {{ $textColor }} mt-1">{{ $cap['remaining'] }}/{{ $cap['max_capacity'] }}</div>
                    <div class="w-full bg-white/10 rounded-full h-1 mt-1">
                        <div class="{{ $barColor }} h-1 rounded-full" style="width: {{ min(100, $percentage) }}%"></div>
                    </div>
                </div>
            @empty
                <div class="col-span-7 text-center text-gray-500 py-12">
                    No capacity data for this month. Use the form above to set capacity.
                </div>
            @endforelse
        </div>
    </div>
@endsection
