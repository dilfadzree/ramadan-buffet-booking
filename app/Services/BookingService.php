<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\DailyCapacity;
use App\Services\SenangPayService;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    public function __construct(private
        AvailabilityService $availabilityService, private
        CapacityService $capacityService, private
        SenangPayService $senangPayService
        )
    {
    }

    /**
     * Create a new booking
     */
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            // Calculate total pax
            $totalPax = ($data['adults'] ?? 0) + ($data['children'] ?? 0) + ($data['oku'] ?? 0);

            // Check availability
            $availability = $this->availabilityService->checkAvailability($data['booking_date'], $totalPax);

            if (!$availability['available']) {
                throw new Exception($availability['message']);
            }

            // Generate booking reference
            $bookingReference = Booking::generateBookingReference();

            // Calculate total amount
            $totalAmount = $this->senangPayService->calculateAmount(
                $data['adults'] ?? 1,
                $data['children'] ?? 0,
                $data['oku'] ?? 0
            );

            // Create booking
            $booking = Booking::create([
                'booking_reference' => $bookingReference,
                'name' => $data['name'],
                'telephone' => $data['telephone'],
                'email' => $data['email'],
                'referral_source' => $data['referral_source'] ?? null,
                'adults' => $data['adults'] ?? 1,
                'children' => $data['children'] ?? 0,
                'oku' => $data['oku'] ?? 0,
                'baby_chairs' => $data['baby_chairs'] ?? 0,
                'total_pax' => $totalPax,
                'total_amount' => $totalAmount,
                'booking_date' => $data['booking_date'],
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'created_by_staff' => $data['created_by_staff'] ?? false,
            ]);

            // Update capacity
            $this->capacityService->updateCurrentBookings($data['booking_date'], $totalPax);

            return $booking;
        });
    }

    /**
     * Update an existing booking
     */
    public function updateBooking(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $oldPax = $booking->total_pax;
            $oldDate = $booking->booking_date;

            // Calculate new total pax
            $newPax = ($data['adults'] ?? $booking->adults)
                + ($data['children'] ?? $booking->children)
                + ($data['oku'] ?? $booking->oku);

            $newDate = $data['booking_date'] ?? $booking->booking_date;

            // If date or pax changed, check availability
            if ($newDate !== $oldDate->format('Y-m-d') || $newPax !== $oldPax) {
                // Release old capacity
                $this->capacityService->updateCurrentBookings($oldDate->format('Y-m-d'), -$oldPax);

                // Check new availability
                $availability = $this->availabilityService->checkAvailability($newDate, $newPax);

                if (!$availability['available']) {
                    // Restore old capacity
                    $this->capacityService->updateCurrentBookings($oldDate->format('Y-m-d'), $oldPax);
                    throw new Exception($availability['message']);
                }

                // Reserve new capacity
                $this->capacityService->updateCurrentBookings($newDate, $newPax);
            }

            // Update booking
            $booking->update([
                'name' => $data['name'] ?? $booking->name,
                'telephone' => $data['telephone'] ?? $booking->telephone,
                'email' => $data['email'] ?? $booking->email,
                'referral_source' => $data['referral_source'] ?? $booking->referral_source,
                'adults' => $data['adults'] ?? $booking->adults,
                'children' => $data['children'] ?? $booking->children,
                'oku' => $data['oku'] ?? $booking->oku,
                'baby_chairs' => $data['baby_chairs'] ?? $booking->baby_chairs,
                'total_pax' => $newPax,
                'booking_date' => $newDate,
                'status' => $data['status'] ?? $booking->status,
            ]);

            return $booking->fresh();
        });
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);

            // Release capacity
            $this->capacityService->updateCurrentBookings(
                $booking->booking_date->format('Y-m-d'),
                -$booking->total_pax
            );

            return $booking;
        });
    }

    /**
     * Get booking statistics
     */
    public function getBookingStats(string $startDate, string $endDate): array
    {
        $bookings = Booking::whereBetween('booking_date', [$startDate, $endDate])->get();

        return [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'total_pax' => $bookings->where('status', 'confirmed')->sum('total_pax'),
            'staff_created' => $bookings->where('created_by_staff', true)->count(),
            'customer_created' => $bookings->where('created_by_staff', false)->count(),
        ];
    }
}
