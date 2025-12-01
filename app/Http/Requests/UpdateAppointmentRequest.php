<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Se valida en policy o middleware
    }

    /**
     * Get the validation rules that apply tothe request.
     */
    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:20',
            'status' => 'required|in:pending,confirmed,completed,rejected',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'patient_name.required' => 'El nombre del paciente es obligatorio.',
            'patient_email.required' => 'El correo electrónico es obligatorio.',
            'patient_email.email' => 'Debe proporcionar un correo electrónico válido.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser: pending, confirmed, completed o rejected.',
        ];
    }
}
