<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCapacityRequest extends FormRequest
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
            'date' => 'nullable|required_without_all:start_date,end_date|date',
            'max_capacity' => 'required|integer|min:1|max:1000',
            // For bulk operations
            'start_date' => 'nullable|required_with:end_date|date',
            'end_date' => 'nullable|required_with:start_date|date|after_or_equal:start_date',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'max_capacity.min' => 'Capacity must be at least 1',
            'max_capacity.max' => 'Capacity cannot exceed 1000',
            'end_date.after_or_equal' => 'End date must be on or after start date',
        ];
    }
}
