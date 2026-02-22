<?php

namespace App\Services;

use App\Models\DailyCapacity;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Check if a date is available for booking
     */
    public function checkAvailability(string $date, int $pax): array
    {
        $capacity = DailyCapacity::where('date', $date)->first();

        if (!$capacity) {
            return [
                'available' => false,
                'remaining_slots' => 0,
                'message' => 'No capacity set for this date'
            ];
        }

        $remaining = $capacity->getRemainingCapacity();

        if ($remaining < $pax) {
            return [
                'available' => false,
                'remaining_slots' => $remaining,
                'message' => "Only {$remaining} slots remaining. Cannot accommodate {$pax} pax."
            ];
        }

        return [
            'available' => true,
            'remaining_slots' => $remaining,
            'message' => "{$remaining} slots available"
        ];
    }

    /**
     * Get available dates for a given month
     */
    public function getAvailableDates(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $capacities = DailyCapacity::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
            return $item->date->format('Y-m-d');
        });

        $availableDates = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateStr = $current->format('Y-m-d');
            $capacity = $capacities->get($dateStr);

            if ($capacity && !$capacity->isFullyBooked()) {
                $availableDates[] = [
                    'date' => $dateStr,
                    'remaining' => $capacity->getRemainingCapacity(),
                    'max_capacity' => $capacity->max_capacity
                ];
            }

            $current->addDay();
        }

        return $availableDates;
    }

    /**
     * Get capacity status for a date
     */
    public function getCapacityStatus(string $date): ?array
    {
        $capacity = DailyCapacity::where('date', $date)->first();

        if (!$capacity) {
            return null;
        }

        return [
            'date' => $date,
            'max_capacity' => $capacity->max_capacity,
            'current_bookings' => $capacity->current_bookings,
            'remaining' => $capacity->getRemainingCapacity(),
            'is_fully_booked' => $capacity->isFullyBooked(),
            'percentage_booked' => round(($capacity->current_bookings / $capacity->max_capacity) * 100, 2)
        ];
    }
}
