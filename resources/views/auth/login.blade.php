@extends('layouts.app')

@section('title', 'Staff Login')

@section('content')
<section class="min-h-screen flex items-center justify-center py-24">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="text-center mb-8">
            <span class="text-4xl mb-4 block">🔐</span>
            <h1 class="font-display text-3xl font-bold text-white">Staff Login</h1>
            <p class="text-gray-400 mt-2">Sign in to access the dashboard</p>
        </div>

        <div class="glass rounded-2xl border border-white/10 p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all"
                        placeholder="staff@ramadanbuffet.com">
                    @error('email')
                        <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all"
                        placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="rounded border-white/20 bg-white/5 text-gold-500 focus:ring-gold-500">
                    <label for="remember" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 py-3 rounded-xl font-bold hover:from-gold-400 hover:to-gold-500 transition-all shadow-lg shadow-gold-500/25">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-gray-500 text-sm mt-6">
            <a href="{{ route('landing') }}" class="text-gold-400 hover:text-gold-300">← Back to home</a>
        </p>
    </div>
</section>
@endsection
