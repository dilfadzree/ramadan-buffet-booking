<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\SenangPayService;
use App\Services\ToyyibPayService;
use App\Events\BookingCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private SenangPayService $senangPayService,
        private ToyyibPayService $toyyibPayService
    ) {}

    /**
     * Show the payment page with gateway selection
     */
    public function show(string $reference)
    {
        $booking = Booking::where('booking_reference', $reference)
            ->where('payment_status', 'unpaid')
            ->firstOrFail();

        $senangPayConfigured = $this->senangPayService->isConfigured();
        $toyyibPayConfigured = $this->toyyibPayService->isConfigured();

        if (!$senangPayConfigured && !$toyyibPayConfigured) {
            return view('payment.not-configured', compact('booking'));
        }

        $senangPayData = $senangPayConfigured
            ? $this->senangPayService->getPaymentData($booking)
            : null;

        return view('payment.checkout', compact(
            'booking',
            'senangPayData',
            'senangPayConfigured',
            'toyyibPayConfigured'
        ));
    }

    /**
     * Initiate ToyyibPay payment (creates bill and redirects)
     */
    public function toyyibPayRedirect(string $reference)
    {
        $booking = Booking::where('booking_reference', $reference)
            ->where('payment_status', 'unpaid')
            ->firstOrFail();

        $result = $this->toyyibPayService->createBill($booking);

        if ($result['success']) {
            // Store the bill code for reference
            $booking->update([
                'senangpay_reference' => $result['bill_code'], // reusing this field for toyyibpay bill code
            ]);

            return redirect($result['payment_url']);
        }

        Log::error('ToyyibPay bill creation failed', ['error' => $result['error']]);

        return redirect()->route('payment.checkout', $booking->booking_reference)
            ->with('error', 'Failed to create payment. Please try again or use another payment method.');
    }

    // =====================================================================
    // SenangPay Handlers
    // =====================================================================

    /**
     * Handle SenangPay return (user is redirected back here)
     */
    public function senangPayReturn(Request $request)
    {
        $statusId = $request->query('status_id');
        $orderId = $request->query('order_id');
        $transactionId = $request->query('transaction_id');
        $msg = $request->query('msg');
        $hash = $request->query('hash');

        Log::info('SenangPay Return', $request->all());

        // Verify hash
        if (!$this->senangPayService->verifyCallbackHash($statusId, $orderId, $transactionId, $msg, $hash)) {
            Log::warning('SenangPay Return: Invalid hash', ['order_id' => $orderId]);
            return redirect()->route('landing')->with('error', 'Payment verification failed.');
        }

        $booking = Booking::where('booking_reference', $orderId)->first();

        if (!$booking) {
            return redirect()->route('landing')->with('error', 'Booking not found.');
        }

        if ($statusId == '1') {
            $this->markBookingPaid($booking, 'senangpay', $transactionId);

            return redirect()->route('booking.confirmation', $booking->booking_reference)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        } else {
            $booking->update([
                'payment_status' => 'failed',
                'transaction_id' => $transactionId,
            ]);

            return redirect()->route('payment.failed', $booking->booking_reference)
                ->with('error', 'Payment was not successful. ' . $msg);
        }
    }

    /**
     * Handle SenangPay callback (server-to-server notification)
     */
    public function senangPayCallback(Request $request)
    {
        $statusId = $request->input('status_id');
        $orderId = $request->input('order_id');
        $transactionId = $request->input('transaction_id');
        $msg = $request->input('msg');
        $hash = $request->input('hash');

        Log::info('SenangPay Callback', $request->all());

        if (!$this->senangPayService->verifyCallbackHash($statusId, $orderId, $transactionId, $msg, $hash)) {
            Log::warning('SenangPay Callback: Invalid hash', ['order_id' => $orderId]);
            return response('FAILED', 400);
        }

        $booking = Booking::where('booking_reference', $orderId)->first();

        if (!$booking) {
            Log::warning('SenangPay Callback: Booking not found', ['order_id' => $orderId]);
            return response('NOT FOUND', 404);
        }

        if ($statusId == '1') {
            $this->markBookingPaid($booking, 'senangpay', $transactionId);
        } else {
            $booking->update([
                'payment_status' => 'failed',
                'transaction_id' => $transactionId,
            ]);
        }

        return response('OK', 200);
    }

    // =====================================================================
    // ToyyibPay Handlers
    // =====================================================================

    /**
     * Handle ToyyibPay return (user is redirected back here)
     *
     * ToyyibPay sends: status_id, billcode, order_id, msg, transaction_id
     */
    public function toyyibPayReturn(Request $request)
    {
        $statusId = $request->query('status_id');
        $billCode = $request->query('billcode');
        $orderId = $request->query('order_id');
        $transactionId = $request->query('transaction_id');

        Log::info('ToyyibPay Return', $request->all());

        $booking = Booking::where('booking_reference', $orderId)->first();

        if (!$booking) {
            return redirect()->route('landing')->with('error', 'Booking not found.');
        }

        if ($statusId == '1') {
            $this->markBookingPaid($booking, 'toyyibpay', $transactionId);

            return redirect()->route('booking.confirmation', $booking->booking_reference)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        } elseif ($statusId == '3') {
            // Pending
            return redirect()->route('booking.confirmation', $booking->booking_reference)
                ->with('info', 'Payment is being processed. You will receive a confirmation soon.');
        } else {
            $booking->update([
                'payment_status' => 'failed',
                'transaction_id' => $transactionId,
            ]);

            return redirect()->route('payment.failed', $booking->booking_reference)
                ->with('error', 'Payment was not successful.');
        }
    }

    /**
     * Handle ToyyibPay callback (server-to-server notification)
     *
     * ToyyibPay sends POST: refno, status, reason, billcode, order_id, amount
     */
    public function toyyibPayCallback(Request $request)
    {
        $refNo = $request->input('refno');
        $status = $request->input('status');
        $reason = $request->input('reason');
        $billCode = $request->input('billcode');
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');

        Log::info('ToyyibPay Callback', $request->all());

        $booking = Booking::where('booking_reference', $orderId)->first();

        if (!$booking) {
            Log::warning('ToyyibPay Callback: Booking not found', ['order_id' => $orderId]);
            return response('NOT FOUND', 404);
        }

        if ($status == '1') {
            $this->markBookingPaid($booking, 'toyyibpay', $refNo);
        } elseif ($status == '3') {
            $booking->update([
                'payment_status' => 'pending',
                'transaction_id' => $refNo,
            ]);
        } else {
            $booking->update([
                'payment_status' => 'failed',
                'transaction_id' => $refNo,
            ]);
        }

        return response('OK', 200);
    }

    // =====================================================================
    // Shared
    // =====================================================================

    /**
     * Show payment failed page
     */
    public function failed(string $reference)
    {
        $booking = Booking::where('booking_reference', $reference)->firstOrFail();
        return view('payment.failed', compact('booking'));
    }

    /**
     * Mark a booking as paid (shared logic)
     */
    private function markBookingPaid(Booking $booking, string $gateway, ?string $transactionId): void
    {
        if ($booking->payment_status === 'paid') {
            return; // Already paid, avoid duplicate processing
        }

        $booking->update([
            'payment_status' => 'paid',
            'payment_method' => $gateway,
            'transaction_id' => $transactionId,
            'status' => 'confirmed',
            'paid_at' => now(),
        ]);

        event(new BookingCreated($booking));
    }
}
