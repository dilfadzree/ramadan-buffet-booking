@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<section class="min-h-screen flex items-center justify-center py-24">
    <div class="max-w-lg mx-auto px-4 text-center">
        <!-- Failed animation -->
        <div class="text-7xl mb-6">❌</div>

        <h1 class="font-display text-4xl font-bold text-white mb-4">Payment Failed</h1>
        <p class="text-gray-400 mb-8">Unfortunately, your payment could not be processed. Your booking has not been confirmed.</p>

        <div class="glass rounded-2xl border border-white/10 p-8 text-left mb-8">
            <h3 class="text-red-400 font-semibold text-lg mb-4 text-center">Booking Details</h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Reference:</span>
                    <span class="text-white font-bold">{{ $booking->booking_reference }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Date:</span>
                    <span class="text-white">{{ $booking->booking_date->format('l, d M Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Total Amount:</span>
                    <span class="text-white font-bold">RM {{ number_format($booking->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between pt-2">
                    <span class="text-gray-400">Status:</span>
                    <span class="text-red-400 font-bold">Payment Failed</span>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-8">
            <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('payment.checkout', $booking->booking_reference) }}"
                class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-8 py-3 rounded-full font-semibold hover:from-gold-400 hover:to-gold-500 transition-all">
                Try Again
            </a>
            <a href="{{ route('landing') }}"
                class="inline-block border border-white/20 text-white px-8 py-3 rounded-full font-semibold hover:bg-white/10 transition-all">
                Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
