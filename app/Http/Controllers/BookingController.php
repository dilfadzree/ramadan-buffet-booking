<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\AvailabilityService;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private
        BookingService $bookingService, private
        AvailabilityService $availabilityService
        )
    {
    }

    /**
     * Show booking form
     */
    public function create()
    {
        return view('booking.form');
    }

    /**
     * Store a new booking
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking created successfully!',
                    'booking' => $booking,
                    'redirect' => route('booking.confirmation', $booking->booking_reference)
                ]);
            }

            return redirect()->route('booking.confirmation', $booking->booking_reference)
                ->with('success', 'Your booking has been confirmed!');
        }
        catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['booking' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show booking confirmation
     */
    public function confirmation(string $reference)
    {
        $booking = Booking::where('booking_reference', $reference)->firstOrFail();
        return view('booking.confirmation', compact('booking'));
    }

    /**
     * Check availability via AJAX
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'pax' => 'nullable|integer|min:1'
        ]);

        $result = $this->availabilityService->checkAvailability(
            $request->date,
            $request->pax ?? 1
        );

        return response()->json($result);
    }

    /**
     * Get available dates for calendar
     */
    public function availableDates(Request $request): JsonResponse
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12'
        ]);

        $dates = $this->availabilityService->getAvailableDates(
            $request->year,
            $request->month
        );

        return response()->json($dates);
    }
}
