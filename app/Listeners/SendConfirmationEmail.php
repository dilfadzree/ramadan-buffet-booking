<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Jobs\SendBookingConfirmationEmail;

class SendConfirmationEmail
{
    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        SendBookingConfirmationEmail::dispatch($event->booking);
    }
}
