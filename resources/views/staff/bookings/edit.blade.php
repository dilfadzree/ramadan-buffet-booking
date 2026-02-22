@extends('layouts.staff')

@section('page_title', 'Edit Booking: ' . $booking->booking_reference)

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('staff.bookings.index') }}" class="text-gray-400 text-sm hover:text-white mb-4 inline-block">← Back to Bookings</a>

        <div class="bg-slate-800 rounded-2xl border border-white/10 p-8">
            <form method="POST" action="{{ route('staff.bookings.update', $booking) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $booking->name) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Phone *</label>
                        <input type="tel" name="telephone" value="{{ old('telephone', $booking->telephone) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $booking->email) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Booking Date *</label>
                        <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Adults *</label>
                        <input type="number" name="adults" value="{{ old('adults', $booking->adults) }}" min="1" max="50" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Children</label>
                        <input type="number" name="children" value="{{ old('children', $booking->children) }}" min="0" max="50"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">OKU</label>
                        <input type="number" name="oku" value="{{ old('oku', $booking->oku) }}" min="0" max="20"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Baby Chairs</label>
                        <input type="number" name="baby_chairs" value="{{ old('baby_chairs', $booking->baby_chairs) }}" min="0" max="10"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }} class="bg-slate-800">Confirmed</option>
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }} class="bg-slate-800">Cancelled</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 py-3 rounded-xl font-bold hover:from-gold-400 hover:to-gold-500 transition-all">
                    Update Booking
                </button>
            </form>
        </div>
    </div>
@endsection
