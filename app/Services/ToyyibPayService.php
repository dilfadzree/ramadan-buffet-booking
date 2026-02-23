<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToyyibPayService
{
    private string $secretKey;
    private string $categoryCode;
    private string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.toyyibpay.secret_key');
        $this->categoryCode = config('services.toyyibpay.category_code');

        // Use sandbox or production URL based on config
        $this->baseUrl = config('services.toyyibpay.sandbox')
            ? 'https://dev.toyyibpay.com'
            : 'https://toyyibpay.com';
    }

    /**
     * Create a bill on ToyyibPay and return the payment URL
     *
     * ToyyibPay API endpoint: POST /index.php/api/createBill
     * Returns an array with BillCode on success.
     */
    public function createBill(Booking $booking): array
    {
        $amount = number_format($booking->total_amount * 100, 0, '', ''); // ToyyibPay uses cents
        $description = "Ramadan Buffet Booking - {$booking->booking_reference} ({$booking->booking_date->format('d M Y')})";

        $params = [
            'userSecretKey' => $this->secretKey,
            'categoryCode' => $this->categoryCode,
            'billName' => 'Ramadan Buffet - ' . $booking->booking_reference,
            'billDescription' => $description,
            'billPriceSetting' => 1, // Fixed price
            'billPayorInfo' => 1,    // Require payor info
            'billAmount' => $amount,
            'billReturnUrl' => route('payment.toyyibpay.return'),
            'billCallbackUrl' => route('payment.toyyibpay.callback'),
            'billExternalReferenceNo' => $booking->booking_reference,
            'billTo' => $booking->name,
            'billEmail' => $booking->email,
            'billPhone' => $booking->telephone,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 2, // 0=FPX, 1=CC, 2=Both
            'billContentEmail' => "Thank you for your Ramadan Buffet booking!\n\nBooking Reference: {$booking->booking_reference}\nDate: {$booking->booking_date->format('d M Y')}\nTotal Pax: {$booking->total_pax}\nAmount: RM " . number_format($booking->total_amount, 2),
            'billChargeToCustomer' => 2, // 0=charge to owner, 1=charge FPX to customer, 2=charge both to customer
        ];

        try {
            $response = Http::asForm()->post("{$this->baseUrl}/index.php/api/createBill", $params);

            $result = $response->json();

            Log::info('ToyyibPay createBill response', ['response' => $result]);

            if (is_array($result) && isset($result[0]['BillCode'])) {
                $billCode = $result[0]['BillCode'];

                return [
                    'success' => true,
                    'bill_code' => $billCode,
                    'payment_url' => "{$this->baseUrl}/{$billCode}",
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to create bill. Response: ' . json_encode($result),
            ];
        } catch (\Exception $e) {
            Log::error('ToyyibPay createBill error', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check if ToyyibPay is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->secretKey) && !empty($this->categoryCode);
    }

    /**
     * Get the base URL
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
