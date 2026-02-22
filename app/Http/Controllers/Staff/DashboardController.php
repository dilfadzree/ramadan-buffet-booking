<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\CapacityService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private CapacityService $capacityService
    ) {}

    /**
     * Display the staff dashboard
     */
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $monthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
        $monthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');

        $todayBookings = Booking::forDate($today)->confirmed()->get();
        $monthStats = $this->bookingService->getBookingStats($monthStart, $monthEnd);
        $capacityStats = $this->capacityService->getCapacityStats($monthStart, $monthEnd);
        $recentBookings = Booking::latest()->take(10)->get();

        return view('staff.dashboard', compact(
            'todayBookings',
            'monthStats',
            'capacityStats',
            'recentBookings'
        ));
    }
}
