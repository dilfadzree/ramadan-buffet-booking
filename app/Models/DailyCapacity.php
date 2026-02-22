<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyCapacity extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'max_capacity',
        'current_bookings',
    ];

    protected $casts = [
        'date' => 'date',
        'max_capacity' => 'integer',
        'current_bookings' => 'integer',
    ];

    /**
     * Get all bookings for this date
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class , 'booking_date', 'date');
    }

    /**
     * Check if date is fully booked
     */
    public function isFullyBooked(): bool
    {
        return $this->current_bookings >= $this->max_capacity;
    }

    /**
     * Get remaining capacity
     */
    public function getRemainingCapacity(): int
    {
        return max(0, $this->max_capacity - $this->current_bookings);
    }

    /**
     * Check if can accommodate pax
     */
    public function canAccommodate(int $pax): bool
    {
        return $this->getRemainingCapacity() >= $pax;
    }

    /**
     * Increment current bookings
     */
    public function incrementBookings(int $pax): void
    {
        $this->increment('current_bookings', $pax);
    }

    /**
     * Decrement current bookings
     */
    public function decrementBookings(int $pax): void
    {
        $this->decrement('current_bookings', $pax);
    }
}
