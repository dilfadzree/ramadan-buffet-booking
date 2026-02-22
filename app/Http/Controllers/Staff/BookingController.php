<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    /**
     * Display all bookings with filtering
     */
    public function index(Request $request)
    {
        $query = Booking::query();

        // Filter by date
        if ($request->filled('date')) {
            $query->forDate($request->date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        // Search by name, email, or reference
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('booking_reference', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDir);

        $bookings = $query->paginate(20)->withQueryString();

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Show manual booking creation form (for walk-ins)
     */
    public function create()
    {
        return view('staff.bookings.create');
    }

    /**
     * Store a manual booking
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by_staff'] = true;

            $booking = $this->bookingService->createBooking($data);

            return redirect()->route('staff.bookings.index')
                ->with('success', "Booking {$booking->booking_reference} created successfully!");
        } catch (\Exception $e) {
            return back()->withErrors(['booking' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking)
    {
        return view('staff.bookings.show', compact('booking'));
    }

    /**
     * Show edit form
     */
    public function edit(Booking $booking)
    {
        return view('staff.bookings.edit', compact('booking'));
    }

    /**
     * Update booking
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $this->bookingService->updateBooking($booking, $request->validated());

            return redirect()->route('staff.bookings.index')
                ->with('success', "Booking {$booking->booking_reference} updated successfully!");
        } catch (\Exception $e) {
            return back()->withErrors(['booking' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        try {
            $this->bookingService->cancelBooking($booking);

            return redirect()->route('staff.bookings.index')
                ->with('success', "Booking {$booking->booking_reference} has been cancelled.");
        } catch (\Exception $e) {
            return back()->withErrors(['booking' => $e->getMessage()]);
        }
    }

    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        $query = Booking::query();

        if ($request->filled('start_date')) {
            $query->where('booking_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('booking_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        $bookings = $query->orderBy('booking_date')->get();

        $filename = 'bookings_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Reference', 'Name', 'Telephone', 'Email', 'Date',
                'Adults', 'Children', 'OKU', 'Baby Chairs', 'Total Pax',
                'Status', 'Source', 'Created By', 'Created At'
            ]);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->name,
                    $booking->telephone,
                    $booking->email,
                    $booking->booking_date->format('Y-m-d'),
                    $booking->adults,
                    $booking->children,
                    $booking->oku,
                    $booking->baby_chairs,
                    $booking->total_pax,
                    $booking->status,
                    $booking->referral_source ?? 'N/A',
                    $booking->created_by_staff ? 'Staff' : 'Customer',
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
