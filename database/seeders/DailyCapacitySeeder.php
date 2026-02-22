<?php

namespace Database\Seeders;

use App\Models\DailyCapacity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DailyCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set capacity for Ramadan 2026 (approximate dates)
        // Ramadan 2026: approximately February 17 - March 18, 2026
        $startDate = Carbon::create(2026, 2, 17);
        $endDate = Carbon::create(2026, 3, 18);

        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            // Set different capacities for weekends vs weekdays
            $isWeekend = $current->isWeekend();
            $maxCapacity = $isWeekend ? 150 : 100;

            DailyCapacity::create([
                'date' => $current->format('Y-m-d'),
                'max_capacity' => $maxCapacity,
                'current_bookings' => 0,
            ]);

            $current->addDay();
        }

        $this->command->info('Created capacity for Ramadan 2026: ' . $startDate->format('M d') . ' - ' . $endDate->format('M d, Y'));
    }
}
