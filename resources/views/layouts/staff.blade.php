<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Dashboard') - Ramadan Buffet</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gold': { 400: '#facc15', 500: '#eab308', 600: '#ca8a04' },
                        'slate': { 750: '#1e293b', 850: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @stack('styles')
</head>
<body class="bg-slate-900 text-white">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-850 border-r border-white/10 flex flex-col fixed h-full z-30">
            <div class="p-6 border-b border-white/10">
                <span class="text-xl">🌙</span>
                <span class="font-bold text-gold-400 ml-2">Staff Panel</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('staff.dashboard') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('staff.dashboard') ? 'bg-gold-500/10 text-gold-400' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    📊 <span>Dashboard</span>
                </a>
                <a href="{{ route('staff.bookings.index') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('staff.bookings.*') ? 'bg-gold-500/10 text-gold-400' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    📋 <span>Bookings</span>
                </a>
                <a href="{{ route('staff.capacity.index') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('staff.capacity.*') ? 'bg-gold-500/10 text-gold-400' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    📅 <span>Capacity</span>
                </a>
                <a href="{{ route('staff.bookings.export') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all">
                    📥 <span>Export</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-gold-500/20 rounded-full flex items-center justify-center text-gold-400 text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Staff</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400 transition-colors">← Sign Out</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top bar -->
            <header class="bg-slate-850 border-b border-white/10 px-8 py-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">@yield('page_title', 'Dashboard')</h1>
                <a href="{{ route('landing') }}" class="text-sm text-gray-400 hover:text-white transition-colors" target="_blank">
                    🌐 View Site
                </a>
            </header>

            <div class="p-8">
                <!-- Flash messages -->
                @if(session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4 mb-6 flex items-center gap-3">
                        <span class="text-emerald-400">✓</span>
                        <p class="text-emerald-400 text-sm">{{ session('success') }}</p>
                    </div>
                @endif
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                        @foreach($errors->all() as $error)
                            <p class="text-red-400 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
