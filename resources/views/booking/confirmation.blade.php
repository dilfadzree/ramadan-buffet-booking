@extends('layouts.app')

@section('title', 'Booking Confirmed')

@section('content')
<section class="min-h-screen flex items-center justify-center py-24">
    <div class="max-w-lg mx-auto px-4 text-center">
        <!-- Success animation -->
        <div class="text-7xl mb-6 animate-bounce">✅</div>
        
        <h1 class="font-display text-4xl font-bold text-white mb-4">Booking Confirmed!</h1>
        <p class="text-gray-400 mb-8">Your table has been reserved. A confirmation email will be sent to you shortly.</p>

        <div class="glass rounded-2xl border border-white/10 p-8 text-left mb-8">
            <h3 class="text-gold-400 font-semibold text-lg mb-4 text-center">Booking Details</h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Reference:</span>
                    <span class="text-gold-400 font-bold text-lg">{{ $booking->booking_reference }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Name:</span>
                    <span class="text-white">{{ $booking->name }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Date:</span>
                    <span class="text-white">{{ $booking->booking_date->format('l, d M Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Adults:</span>
                    <span class="text-white">{{ $booking->adults }} pax</span>
                </div>
                @if($booking->children > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Children:</span>
                    <span class="text-white">{{ $booking->children }} pax</span>
                </div>
                @endif
                @if($booking->oku > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">OKU:</span>
                    <span class="text-white">{{ $booking->oku }} pax</span>
                </div>
                @endif
                @if($booking->baby_chairs > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Baby Chairs:</span>
                    <span class="text-white">{{ $booking->baby_chairs }}</span>
                </div>
                @endif
                <div class="flex justify-between pt-2">
                    <span class="text-gray-400">Total Pax:</span>
                    <span class="text-white font-bold text-lg">{{ $booking->total_pax }} pax</span>
                </div>
            </div>
        </div>

        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4 mb-8">
            <p class="text-emerald-400 text-sm">📧 A confirmation email has been sent to <strong>{{ $booking->email }}</strong></p>
        </div>

        <a href="{{ route('landing') }}" class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-8 py-3 rounded-full font-semibold hover:from-gold-400 hover:to-gold-500 transition-all">
            Back to Home
        </a>
    </div>
</section>
@endsection
