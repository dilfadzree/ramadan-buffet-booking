<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'name',
        'telephone',
        'email',
        'referral_source',
        'adults',
        'children',
        'oku',
        'baby_chairs',
        'total_pax',
        'booking_date',
        'status',
        'created_by_staff',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'created_by_staff' => 'boolean',
        'adults' => 'integer',
        'children' => 'integer',
        'oku' => 'integer',
        'baby_chairs' => 'integer',
        'total_pax' => 'integer',
    ];

    /**
     * Get the total pax (computed attribute)
     */
    public function getTotalPaxAttribute(): int
    {
        return $this->adults + $this->children + $this->oku;
    }

    /**
     * Scope to filter by date
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('booking_date', $date);
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for confirmed bookings only
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Generate a unique booking reference
     */
    public static function generateBookingReference(): string
    {
        do {
            $reference = 'RB' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
