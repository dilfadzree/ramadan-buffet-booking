<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public booking form
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/'],
            'email' => 'required|email|max:255',
            'referral_source' => 'nullable|string|in:Social Media,Friends/Family,Google,Walk-by,Other',
            'adults' => 'required|integer|min:1|max:50',
            'children' => 'nullable|integer|min:0|max:50',
            'oku' => 'nullable|integer|min:0|max:20',
            'baby_chairs' => 'nullable|integer|min:0|max:10',
            'booking_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'telephone.regex' => 'Please enter a valid Malaysian phone number (e.g., 012-3456789)',
            'booking_date.after_or_equal' => 'Booking date must be today or a future date',
            'adults.min' => 'At least 1 adult is required for booking',
        ];
    }
}
