<?php

namespace App\Services;

use App\Models\Booking;

class SenangPayService
{
    private string $merchantId;
    private string $secretKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('services.senangpay.merchant_id');
        $this->secretKey = config('services.senangpay.secret_key');

        // Use sandbox or production URL based on config
        $this->baseUrl = config('services.senangpay.sandbox')
            ? 'https://sandbox.senangpay.my/payment'
            : 'https://app.senangpay.my/payment';
    }

    /**
     * Calculate total amount for a booking
     */
    public function calculateAmount(int $adults, int $children, int $oku): float
    {
        $adultPrice = config('services.senangpay.prices.adult', 89);
        $childPrice = config('services.senangpay.prices.child', 45);
        $okuPrice = config('services.senangpay.prices.oku', 45);

        return ($adults * $adultPrice) + ($children * $childPrice) + ($oku * $okuPrice);
    }

    /**
     * Generate the payment URL and form data for SenangPay
     *
     * SenangPay Open API uses form POST with hash verification.
     * Hash = md5(secretkey . detail . amount . order_id)
     */
    public function getPaymentData(Booking $booking): array
    {
        $detail = "Ramadan Buffet Booking - {$booking->booking_reference} ({$booking->booking_date->format('d M Y')})";
        $amount = number_format($booking->total_amount, 2, '.', '');
        $orderId = $booking->booking_reference;
        $name = $booking->name;
        $email = $booking->email;
        $phone = $booking->telephone;

        // Generate hash: md5(secretkey . detail . amount . order_id)
        $hash = md5($this->secretKey . $detail . $amount . $orderId);

        return [
            'url' => $this->baseUrl . '/' . $this->merchantId,
            'detail' => $detail,
            'amount' => $amount,
            'order_id' => $orderId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'hash' => $hash,
        ];
    }

    /**
     * Verify the callback/return hash from SenangPay
     *
     * Return hash = md5(secretkey . status_id . order_id . transaction_id . msg)
     */
    public function verifyCallbackHash(
        string $statusId,
        string $orderId,
        string $transactionId,
        string $msg,
        string $hash
    ): bool {
        $expectedHash = md5($this->secretKey . $statusId . $orderId . $transactionId . $msg);
        return $expectedHash === $hash;
    }

    /**
     * Get the payment URL (for display/reference)
     */
    public function getPaymentUrl(): string
    {
        return $this->baseUrl . '/' . $this->merchantId;
    }

    /**
     * Check if SenangPay is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->merchantId) && !empty($this->secretKey);
    }
}
