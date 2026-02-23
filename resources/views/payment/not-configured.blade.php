@extends('layouts.app')

@section('title', 'Payment Not Configured')

@section('content')
<section class="min-h-screen flex items-center justify-center py-24">
    <div class="max-w-lg mx-auto px-4 text-center">
        <div class="text-7xl mb-6">⚙️</div>

        <h1 class="font-display text-3xl font-bold text-white mb-4">Payment Gateway Not Configured</h1>
        <p class="text-gray-400 mb-8">
            The payment gateway has not been set up yet. Please contact the administrator to configure SenangPay credentials.
        </p>

        <div class="glass rounded-2xl border border-white/10 p-8 text-left mb-8">
            <h3 class="text-gold-400 font-semibold text-lg mb-4 text-center">Your Booking is Reserved</h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Reference:</span>
                    <span class="text-gold-400 font-bold">{{ $booking->booking_reference }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Date:</span>
                    <span class="text-white">{{ $booking->booking_date->format('l, d M Y') }}</span>
                </div>
                <div class="flex justify-between pt-2">
                    <span class="text-gray-400">Amount Due:</span>
                    <span class="text-gold-400 font-bold text-lg">RM {{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-4 mb-8">
            <p class="text-amber-400 text-sm">⚠️ Your booking is pending payment. Please complete payment once the payment gateway is available.</p>
        </div>

        <a href="{{ route('landing') }}" class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-8 py-3 rounded-full font-semibold hover:from-gold-400 hover:to-gold-500 transition-all">
            Back to Home
        </a>
    </div>
</section>
@endsection
