@extends('layouts.app')

@section('title', 'Authentic Kampung Flavors')
@section('description', 'Book your Ramadan Buffet experience. Premium kampung-style dining with authentic Malaysian flavors.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-emerald-950 to-gray-900"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZGUwNDciIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDM0djJoLTJ2LTJoMnptMC00aDJ2MmgtMnYtMnptLTQgOHYtMmgydjJoLTJ6bTQtMTJoMnYyaC0ydi0yem0tOCA4di0yaDJ2MmgtMnptLTQgMGgtMnYtMmgydjJ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-50"></div>
        
        <!-- Floating decorative elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-gold-500/10 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-500/10 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s"></div>
        
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <!-- Moon decoration -->
            <div class="text-7xl mb-6 animate-fade-in-up">🌙</div>
            
            <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-bold mb-6 animate-fade-in-up animate-delay-100">
                <span class="gradient-text">Authentic</span><br>
                <span class="text-white">Kampung Flavors</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-4 animate-fade-in-up animate-delay-200">
                Indulge in our exquisite Ramadan Buffet featuring over 100 dishes of traditional Malaysian cuisine, prepared fresh daily with the finest ingredients.
            </p>
            
            <p class="text-gold-400 text-lg font-semibold mb-8 animate-fade-in-up animate-delay-200">
                🗓️ 17 Feb - 18 March 2026 &nbsp;|&nbsp; ⏰ 6:00 PM - 10:00 PM
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up animate-delay-300">
                <a href="#booking" class="group bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:from-gold-400 hover:to-gold-500 transition-all shadow-xl shadow-gold-500/25 hover:shadow-gold-500/40 transform hover:-translate-y-1">
                    Book My Table
                    <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                </a>
                <a href="#pricing" class="border border-white/20 text-white px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition-all">
                    View Pricing
                </a>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-gray-800"></div>
        
        <div class="relative z-10 max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-gold-400 font-semibold text-sm uppercase tracking-wider">Our Packages</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mt-2">Pricing Plans</h2>
                <p class="text-gray-400 mt-4 max-w-xl mx-auto">Choose the perfect dining experience for you and your loved ones</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Adult -->
                <div class="glass rounded-2xl border border-white/10 p-8 text-center hover:border-gold-500/50 transition-all duration-300 hover:transform hover:-translate-y-2 hover:shadow-xl hover:shadow-gold-500/10 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">👤</span>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Adult</h3>
                    <p class="text-gray-400 text-sm mb-6">Ages 13 and above</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold gradient-text">RM 89</span>
                        <span class="text-gray-400">/pax</span>
                    </div>
                    <ul class="text-sm text-gray-300 space-y-3 mb-8">
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> 100+ Buffet Dishes
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Live Cooking Station
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Dessert Bar
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Free Flow Drinks
                        </li>
                    </ul>
                    <a href="#booking" class="block w-full bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 py-3 rounded-xl font-semibold hover:from-gold-400 hover:to-gold-500 transition-all">
                        Book Now
                    </a>
                </div>
                
                <!-- Child -->
                <div class="glass rounded-2xl border border-white/10 p-8 text-center hover:border-emerald-500/50 transition-all duration-300 hover:transform hover:-translate-y-2 hover:shadow-xl hover:shadow-emerald-500/10 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">👧</span>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-white mb-2">Child</h3>
                    <p class="text-gray-400 text-sm mb-6">Ages 4 - 12</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-emerald-400">RM 45</span>
                        <span class="text-gray-400">/pax</span>
                    </div>
                    <ul class="text-sm text-gray-300 space-y-3 mb-8">
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Full Buffet Access
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Kid-Friendly Options
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Dessert Bar
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Free Flow Drinks
                        </li>
                    </ul>
                    <a href="#booking" class="block w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:from-emerald-400 hover:to-emerald-500 transition-all">
                        Book Now
                    </a>
                </div>
                
                <!-- OKU -->
                <div class="glass rounded-2xl border border-white/10 p-8 text-center hover:border-purple-500/50 transition-all duration-300 hover:transform hover:-translate-y-2 hover:shadow-xl hover:shadow-purple-500/10 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">♿</span>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-white mb-2">OKU</h3>
                    <p class="text-gray-400 text-sm mb-6">Persons with Disabilities</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-purple-400">RM 45</span>
                        <span class="text-gray-400">/pax</span>
                    </div>
                    <ul class="text-sm text-gray-300 space-y-3 mb-8">
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Full Buffet Access
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Priority Seating
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Wheelchair Accessible
                        </li>
                        <li class="flex items-center justify-center gap-2">
                            <span class="text-emerald-400">✓</span> Free Flow Drinks
                        </li>
                    </ul>
                    <a href="#booking" class="block w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-purple-400 hover:to-purple-500 transition-all">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-800 to-gray-900"></div>
        
        <div class="relative z-10 max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-gold-400 font-semibold text-sm uppercase tracking-wider">Our Facilities</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mt-2">Premium Dining Experience</h2>
                <p class="text-gray-400 mt-4 max-w-xl mx-auto">Everything you need for a comfortable and enjoyable iftar</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                $features = [
                    ['icon' => '🕌', 'title' => 'Surau', 'desc' => 'Prayer room available for all guests'],
                    ['icon' => '🅿️', 'title' => 'Free Parking', 'desc' => 'Ample parking space for all vehicles'],
                    ['icon' => '👶', 'title' => 'Baby Chairs', 'desc' => 'Available upon request for families'],
                    ['icon' => '♿', 'title' => 'Wheelchair Access', 'desc' => 'Fully accessible dining area'],
                    ['icon' => '❄️', 'title' => 'Air Conditioned', 'desc' => 'Comfortable cool dining environment'],
                    ['icon' => '🍳', 'title' => 'Live Cooking', 'desc' => 'Fresh food prepared before your eyes'],
                    ['icon' => '📶', 'title' => 'Free WiFi', 'desc' => 'Stay connected during your visit'],
                    ['icon' => '🎵', 'title' => 'Nasyid Live', 'desc' => 'Soothing performances during iftar'],
                ];
                @endphp
                
                @foreach($features as $feature)
                <div class="glass rounded-2xl border border-white/10 p-6 text-center hover:border-gold-500/30 transition-all duration-300 group">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $feature['icon'] }}</div>
                    <h3 class="text-white font-semibold mb-1">{{ $feature['title'] }}</h3>
                    <p class="text-gray-400 text-xs">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-emerald-950 to-gray-900"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gold-500/5 rounded-full filter blur-3xl"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-gold-400 font-semibold text-sm uppercase tracking-wider">Reserve Your Spot</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mt-2">Book Your Table</h2>
                <p class="text-gray-400 mt-4">Secure your Ramadan dining experience today</p>
            </div>
            
            <!-- Booking Form -->
            <div class="glass rounded-3xl border border-white/10 p-8 md:p-12" x-data="bookingForm()">
                @csrf
                
                <!-- Date Selection -->
                <div class="mb-8">
                    <label class="block text-gold-400 font-semibold mb-3">Select Date</label>
                    <div class="grid grid-cols-7 gap-2 mb-4" x-show="availableDates.length > 0">
                        <template x-for="date in calendarDates" :key="date.dateStr">
                            <button type="button"
                                @click="selectDate(date)"
                                :class="{
                                    'bg-gold-500 text-gray-900 font-bold': selectedDate === date.dateStr,
                                    'bg-white/5 hover:bg-white/10 text-white': selectedDate !== date.dateStr && date.available,
                                    'bg-white/5 text-gray-600 cursor-not-allowed': !date.available,
                                    'ring-2 ring-gold-500': selectedDate === date.dateStr
                                }"
                                :disabled="!date.available"
                                class="p-2 rounded-lg text-sm transition-all"
                            >
                                <div class="font-semibold" x-text="date.day"></div>
                                <div class="text-xs" x-text="date.monthShort"></div>
                            </button>
                        </template>
                    </div>
                    <div x-show="availableDates.length === 0" class="text-gray-400 text-center py-4">
                        Loading available dates...
                    </div>
                    <div x-show="selectedDate" class="text-sm mt-2">
                        <span class="text-emerald-400" x-text="availabilityMessage"></span>
                    </div>
                </div>

                <!-- Hidden date input -->
                <input type="hidden" name="booking_date" x-model="selectedDate">
                
                <!-- Contact Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Full Name *</label>
                        <input type="text" name="name" required x-model="form.name"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all"
                            placeholder="Enter your full name">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Phone Number *</label>
                        <input type="tel" name="telephone" required x-model="form.telephone"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all"
                            placeholder="012-345 6789">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Email Address *</label>
                        <input type="email" name="email" required x-model="form.email"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all"
                            placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">How did you hear about us?</label>
                        <select name="referral_source" x-model="form.referral_source"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition-all">
                            <option value="" class="bg-gray-800">Select an option</option>
                            <option value="Social Media" class="bg-gray-800">Social Media</option>
                            <option value="Friends/Family" class="bg-gray-800">Friends / Family</option>
                            <option value="Google" class="bg-gray-800">Google</option>
                            <option value="Walk-by" class="bg-gray-800">Walk-by</option>
                            <option value="Other" class="bg-gray-800">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Pax Selection -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Adults *</label>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="form.adults = Math.max(1, form.adults - 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">-</button>
                            <input type="number" name="adults" x-model.number="form.adults" min="1" max="50"
                                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-center focus:outline-none focus:border-gold-500 transition-all">
                            <button type="button" @click="form.adults = Math.min(50, form.adults + 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Children</label>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="form.children = Math.max(0, form.children - 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">-</button>
                            <input type="number" name="children" x-model.number="form.children" min="0" max="50"
                                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-center focus:outline-none focus:border-gold-500 transition-all">
                            <button type="button" @click="form.children = Math.min(50, form.children + 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">OKU</label>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="form.oku = Math.max(0, form.oku - 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">-</button>
                            <input type="number" name="oku" x-model.number="form.oku" min="0" max="20"
                                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-center focus:outline-none focus:border-gold-500 transition-all">
                            <button type="button" @click="form.oku = Math.min(20, form.oku + 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Baby Chairs</label>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="form.baby_chairs = Math.max(0, form.baby_chairs - 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">-</button>
                            <input type="number" name="baby_chairs" x-model.number="form.baby_chairs" min="0" max="10"
                                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-center focus:outline-none focus:border-gold-500 transition-all">
                            <button type="button" @click="form.baby_chairs = Math.min(10, form.baby_chairs + 1)" class="w-10 h-10 bg-white/10 rounded-lg text-white hover:bg-white/20 transition-all">+</button>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="glass rounded-2xl border border-gold-500/20 p-6 mb-8">
                    <h4 class="text-gold-400 font-semibold mb-3">Booking Summary</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span class="text-gray-400">Date:</span>
                        <span class="text-white" x-text="selectedDate || 'Not selected'"></span>
                        <span class="text-gray-400">Total Pax:</span>
                        <span class="text-white" x-text="totalPax + ' pax'"></span>
                        <span class="text-gray-400">Estimated Total:</span>
                        <span class="text-gold-400 font-bold" x-text="'RM ' + estimatedTotal"></span>
                    </div>
                </div>

                <!-- Error messages -->
                <div x-show="errorMessage" class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                    <p class="text-red-400 text-sm" x-text="errorMessage"></p>
                </div>

                <!-- Submit -->
                <button type="button"
                    @click="submitBooking()"
                    :disabled="submitting || !selectedDate"
                    :class="{ 'opacity-50 cursor-not-allowed': submitting || !selectedDate }"
                    class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-gray-900 py-4 rounded-xl font-bold text-lg hover:from-gold-400 hover:to-gold-500 transition-all shadow-xl shadow-gold-500/25 transform hover:-translate-y-0.5">
                    <span x-show="!submitting">Confirm Booking</span>
                    <span x-show="submitting" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
function bookingForm() {
    return {
        selectedDate: '',
        availableDates: [],
        calendarDates: [],
        availabilityMessage: '',
        submitting: false,
        errorMessage: '',
        form: {
            name: '',
            telephone: '',
            email: '',
            referral_source: '',
            adults: 1,
            children: 0,
            oku: 0,
            baby_chairs: 0,
        },

        get totalPax() {
            return this.form.adults + this.form.children + this.form.oku;
        },

        get estimatedTotal() {
            return (this.form.adults * 89) + (this.form.children * 45) + (this.form.oku * 45);
        },

        async init() {
            await this.loadAvailableDates();
        },

        async loadAvailableDates() {
            try {
                // Load current and next month
                const now = new Date();
                const res1 = await fetch(`/api/available-dates?year=${now.getFullYear()}&month=${now.getMonth() + 1}`);
                const dates1 = await res1.json();
                
                const nextMonth = new Date(now.getFullYear(), now.getMonth() + 1, 1);
                const res2 = await fetch(`/api/available-dates?year=${nextMonth.getFullYear()}&month=${nextMonth.getMonth() + 1}`);
                const dates2 = await res2.json();

                this.availableDates = [...dates1, ...dates2];
                this.buildCalendar();
            } catch (e) {
                console.error('Failed to load dates:', e);
                this.buildCalendar();
            }
        },

        buildCalendar() {
            // Build a simple list of dates for the Ramadan period
            const start = new Date(2026, 1, 17); // Feb 17, 2026
            const end = new Date(2026, 2, 18);   // Mar 18, 2026
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

            this.calendarDates = [];
            let current = new Date(start);
            const today = new Date();
            today.setHours(0,0,0,0);

            while (current <= end) {
                const dateStr = current.toISOString().split('T')[0];
                const available = current >= today && this.availableDates.some(d => d.date === dateStr);
                
                this.calendarDates.push({
                    dateStr: dateStr,
                    day: current.getDate(),
                    monthShort: months[current.getMonth()],
                    available: available,
                    remaining: this.availableDates.find(d => d.date === dateStr)?.remaining || 0
                });
                
                current.setDate(current.getDate() + 1);
            }
        },

        async selectDate(date) {
            if (!date.available) return;
            this.selectedDate = date.dateStr;
            
            try {
                const res = await fetch(`/api/check-availability?date=${date.dateStr}&pax=${this.totalPax}`);
                const data = await res.json();
                this.availabilityMessage = data.message;
            } catch (e) {
                this.availabilityMessage = `${date.remaining} slots remaining`;
            }
        },

        async submitBooking() {
            this.errorMessage = '';
            
            if (!this.selectedDate) {
                this.errorMessage = 'Please select a date';
                return;
            }
            if (!this.form.name || !this.form.telephone || !this.form.email) {
                this.errorMessage = 'Please fill in all required fields';
                return;
            }
            
            this.submitting = true;

            try {
                const res = await fetch('{{ route("booking.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        ...this.form,
                        booking_date: this.selectedDate
                    })
                });

                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.errorMessage = data.message || 'Booking failed. Please try again.';
                }
            } catch (e) {
                this.errorMessage = 'An error occurred. Please try again.';
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>
@endpush
