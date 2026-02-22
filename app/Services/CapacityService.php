<?php

namespace App\Services;

use App\Models\DailyCapacity;
use Carbon\Carbon;

class CapacityService
{
    /**
     * Set capacity for a specific date
     */
    public function setCapacity(string $date, int $maxCapacity): DailyCapacity
    {
        return DailyCapacity::updateOrCreate(
        ['date' => $date],
        ['max_capacity' => $maxCapacity]
        );
    }

    /**
     * Set capacity for a date range
     */
    public function setCapacityForDateRange(string $startDate, string $endDate, int $maxCapacity): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $count = 0;

        while ($start->lte($end)) {
            $this->setCapacity($start->format('Y-m-d'), $maxCapacity);
            $start->addDay();
            $count++;
        }

        return $count;
    }

    /**
     * Update current bookings for a date
     */
    public function updateCurrentBookings(string $date, int $delta): void
    {
        $capacity = DailyCapacity::firstOrCreate(
        ['date' => $date],
        ['max_capacity' => 100] // default capacity
        );

        $capacity->increment('current_bookings', $delta);
    }

    /**
     * Get capacity statistics for a date range
     */
    public function getCapacityStats(string $startDate, string $endDate): array
    {
        $capacities = DailyCapacity::whereBetween('date', [$startDate, $endDate])->get();

        $totalCapacity = $capacities->sum('max_capacity');
        $totalBookings = $capacities->sum('current_bookings');
        $fullyBookedDays = $capacities->filter(fn($c) => $c->isFullyBooked())->count();

        return [
            'total_capacity' => $totalCapacity,
            'total_bookings' => $totalBookings,
            'remaining_capacity' => $totalCapacity - $totalBookings,
            'utilization_percentage' => $totalCapacity > 0 ? round(($totalBookings / $totalCapacity) * 100, 2) : 0,
            'fully_booked_days' => $fullyBookedDays,
            'total_days' => $capacities->count()
        ];
    }

    /**
     * Get capacities for a specific month
     */
    public function getMonthCapacities(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        return DailyCapacity::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get()
            ->map(function ($capacity) {
            return [
                'date' => $capacity->date->format('Y-m-d'),
                'max_capacity' => $capacity->max_capacity,
                'current_bookings' => $capacity->current_bookings,
                'remaining' => $capacity->getRemainingCapacity(),
                'is_fully_booked' => $capacity->isFullyBooked()
            ];
        })
            ->toArray();
    }
}
