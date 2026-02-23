@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<section class="min-h-screen flex items-center justify-center py-24">
    <div class="max-w-lg mx-auto px-4">
        <!-- Payment Header -->
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">💳</div>
            <h1 class="font-display text-3xl font-bold text-white mb-2">Complete Your Payment</h1>
            <p class="text-gray-400">Choose your preferred payment method below.</p>
        </div>

        <!-- Error Messages -->
        @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
            <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        <!-- Booking Summary Card -->
        <div class="glass rounded-2xl border border-white/10 p-8 mb-8">
            <h3 class="text-gold-400 font-semibold text-lg mb-4 text-center">Booking Summary</h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Reference:</span>
                    <span class="text-gold-400 font-bold">{{ $booking->booking_reference }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Name:</span>
                    <span class="text-white">{{ $booking->name }}</span>
                </div>
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Date:</span>
                    <span class="text-white">{{ $booking->booking_date->format('l, d M Y') }}</span>
                </div>

                @if($booking->adults > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Adults ({{ $booking->adults }} × RM89):</span>
                    <span class="text-white">RM {{ number_format($booking->adults * 89, 2) }}</span>
                </div>
                @endif
                @if($booking->children > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">Children ({{ $booking->children }} × RM45):</span>
                    <span class="text-white">RM {{ number_format($booking->children * 45, 2) }}</span>
                </div>
                @endif
                @if($booking->oku > 0)
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span class="text-gray-400">OKU ({{ $booking->oku }} × RM45):</span>
                    <span class="text-white">RM {{ number_format($booking->oku * 45, 2) }}</span>
                </div>
                @endif

                <div class="flex justify-between pt-2">
                    <span class="text-white font-semibold text-lg">Total Amount:</span>
                    <span class="text-gold-400 font-bold text-2xl">RM {{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="space-y-4 mb-6">
            <h4 class="text-white font-semibold text-center">Select Payment Method</h4>

            {{-- SenangPay --}}
            @if($senangPayConfigured)
            <form action="{{ $senangPayData['url'] }}" method="POST">
                <input type="hidden" name="detail" value="{{ $senangPayData['detail'] }}">
                <input type="hidden" name="amount" value="{{ $senangPayData['amount'] }}">
                <input type="hidden" name="order_id" value="{{ $senangPayData['order_id'] }}">
                <input type="hidden" name="name" value="{{ $senangPayData['name'] }}">
                <input type="hidden" name="email" value="{{ $senangPayData['email'] }}">
                <input type="hidden" name="phone" value="{{ $senangPayData['phone'] }}">
                <input type="hidden" name="hash" value="{{ $senangPayData['hash'] }}">

                <button type="submit"
                    class="w-full glass border border-white/10 hover:border-emerald-500/50 rounded-xl p-5 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/10 group flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div class="text-left flex-grow">
                        <div class="text-white font-semibold text-lg group-hover:text-emerald-400 transition-colors">SenangPay</div>
                        <div class="text-gray-400 text-sm">FPX, Credit/Debit Card</div>
                    </div>
                    <div class="text-gray-400 group-hover:text-emerald-400 transition-colors flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>
            </form>
            @endif

            {{-- ToyyibPay --}}
            @if($toyyibPayConfigured)
            <a href="{{ route('payment.toyyibpay.redirect', $booking->booking_reference) }}"
                class="w-full glass border border-white/10 hover:border-blue-500/50 rounded-xl p-5 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10 group flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-left flex-grow">
                    <div class="text-white font-semibold text-lg group-hover:text-blue-400 transition-colors">ToyyibPay</div>
                    <div class="text-gray-400 text-sm">FPX, Credit/Debit Card</div>
                </div>
                <div class="text-gray-400 group-hover:text-blue-400 transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endif
        </div>

        <div class="text-center">
            <p class="text-gray-500 text-xs mb-4">
                🔒 Your payment is processed securely. We do not store your card details.
            </p>
            <a href="{{ route('landing') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                ← Cancel and return to homepage
            </a>
        </div>
    </div>
</section>
@endsection
