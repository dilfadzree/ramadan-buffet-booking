<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isStaff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'telephone' => ['sometimes', 'required', 'regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/'],
            'email' => 'sometimes|required|email|max:255',
            'referral_source' => 'nullable|string',
            'adults' => 'sometimes|required|integer|min:1|max:50',
            'children' => 'nullable|integer|min:0|max:50',
            'oku' => 'nullable|integer|min:0|max:20',
            'baby_chairs' => 'nullable|integer|min:0|max:10',
            'booking_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:pending,confirmed,cancelled',
        ];
    }
}
