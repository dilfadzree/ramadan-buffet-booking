@extends('layouts.staff')

@section('page_title', 'Create Manual Booking')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('staff.bookings.index') }}" class="text-gray-400 text-sm hover:text-white mb-4 inline-block">← Back to Bookings</a>

        <div class="bg-slate-800 rounded-2xl border border-white/10 p-8">
            <h2 class="text-lg font-semibold mb-6">Walk-in / Manual Booking</h2>

            <form method="POST" action="{{ route('staff.bookings.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Phone *</label>
                        <input type="tel" name="telephone" value="{{ old('telephone') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        @error('telephone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Booking Date *</label>
                        <input type="date" name="booking_date" value="{{ old('booking_date') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        @error('booking_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Adults *</label>
                        <input type="number" name="adults" value="{{ old('adults', 1) }}" min="1" max="50" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Children</label>
                        <input type="number" name="children" value="{{ old('children', 0) }}" min="0" max="50"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">OKU</label>
                        <input type="number" name="oku" value="{{ old('oku', 0) }}" min="0" max="20"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Baby Chairs</label>
                        <input type="number" name="baby_chairs" value="{{ old('baby_chairs', 0) }}" min="0" max="10"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all text-center">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Referral Source</label>
                    <select name="referral_source" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 transition-all">
                        <option value="" class="bg-slate-800">Select...</option>
                        <option value="Social Media" class="bg-slate-800">Social Media</option>
                        <option value="Friends/Family" class="bg-slate-800">Friends / Family</option>
                        <option value="Google" class="bg-slate-800">Google</option>
                        <option value="Walk-by" class="bg-slate-800">Walk-by</option>
                        <option value="Other" class="bg-slate-800">Other</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 py-3 rounded-xl font-bold hover:from-gold-400 hover:to-gold-500 transition-all">
                    Create Booking
                </button>
            </form>
        </div>
    </div>
@endsection
