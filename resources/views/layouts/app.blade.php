<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ramadan Buffet Booking') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', 'Book your Ramadan Buffet experience - Authentic Kampung Flavors with premium dining.')">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gold': { 50: '#fefce8', 100: '#fef9c3', 200: '#fef08a', 300: '#fde047', 400: '#facc15', 500: '#eab308', 600: '#ca8a04', 700: '#a16207', 800: '#854d0e', 900: '#713f12' },
                        'emerald': { 50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 300: '#6ee7b7', 400: '#34d399', 500: '#10b981', 600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b' },
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a2e; }
        ::-webkit-scrollbar-thumb { background: #eab308; border-radius: 4px; }
        
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }
        
        .glass {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fde047, #eab308, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-900 text-white min-h-screen font-body">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/10" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                    <span class="text-2xl">🌙</span>
                    <span class="font-display text-xl font-bold gradient-text">Ramadan Buffet</span>
                </a>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('landing') }}#pricing" class="text-gray-300 hover:text-gold-400 transition-colors">Pricing</a>
                    <a href="{{ route('landing') }}#features" class="text-gray-300 hover:text-gold-400 transition-colors">Facilities</a>
                    <a href="{{ route('booking.create') }}" class="bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-6 py-2 rounded-full font-semibold hover:from-gold-400 hover:to-gold-500 transition-all shadow-lg shadow-gold-500/25">
                        Book Now
                    </a>
                    @auth
                        @if(Auth::user()->isStaff())
                            <a href="{{ route('staff.dashboard') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="text-gray-400 hover:text-white transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Staff Login</a>
                    @endauth
                </div>
                
                <!-- Mobile menu -->
                <button @click="open = !open" class="md:hidden text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile menu panel -->
            <div x-show="open" x-transition class="md:hidden pb-4 space-y-2">
                <a href="{{ route('landing') }}#pricing" class="block px-4 py-2 text-gray-300 hover:text-gold-400">Pricing</a>
                <a href="{{ route('landing') }}#features" class="block px-4 py-2 text-gray-300 hover:text-gold-400">Facilities</a>
                <a href="{{ route('booking.create') }}" class="block px-4 py-2 text-gold-400 font-semibold">Book Now</a>
                @auth
                    @if(Auth::user()->isStaff())
                        <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 text-emerald-400">Dashboard</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 border-t border-white/10 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-display text-xl font-bold gradient-text mb-4">Ramadan Buffet</h3>
                    <p class="text-gray-400 text-sm">Experience the finest Ramadan dining with authentic kampung flavors and premium service.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('landing') }}#pricing" class="hover:text-gold-400 transition-colors">Pricing</a></li>
                        <li><a href="{{ route('landing') }}#features" class="hover:text-gold-400 transition-colors">Facilities</a></li>
                        <li><a href="{{ route('booking.create') }}" class="hover:text-gold-400 transition-colors">Book Now</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📍 Venue Address Here</li>
                        <li>📞 +60 12-345 6789</li>
                        <li>📧 info@ramadanbuffet.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-white/10 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Ramadan Buffet Booking. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
