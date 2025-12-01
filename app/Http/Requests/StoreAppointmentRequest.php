<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Público puede crear citas
    }

    /**
     * Prepare data for validation - convert 'start' to 'start_at'.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('start') && !$this->has('start_at')) {
            $this->merge(['start_at' => $this->start]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:20',
            'start_at' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $this->validateAvailabilityAndCollision($value, $fail);
                },
            ],
        ];
    }

    /**
     * Validar disponibilidad y colisiones
     */
    protected function validateAvailabilityAndCollision($value, $fail)
    {
        $doctorId = $this->input('doctor_id');
        $doctor = Doctor::find($doctorId);

        if (!$doctor) {
            return;
        }

        if (!$doctor->is_active) {
            $fail('El médico seleccionado no está activo.');
            return;
        }

        $appointmentService = new AppointmentService();
        $startAt = Carbon::parse($value);
        $endAt = $appointmentService->calculateEndTime($startAt);

        // Verificar disponibilidad semanal
        if (!$appointmentService->isWithinAvailability($doctor, $startAt, $endAt)) {
            $fail('El horario seleccionado no está dentro de la disponibilidad del médico.');
            return;
        }

        // Verificar colisiones
        if ($appointmentService->checkCollision($doctorId, $startAt, $endAt)) {
            $fail('El horario ya está reservado o en espera para este médico.');
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Debe seleccionar un médico.',
            'doctor_id.exists' => 'El médico seleccionado no existe.',
            'patient_name.required' => 'El nombre del paciente es obligatorio.',
            'patient_email.required' => 'El correo electrónico es obligatorio.',
            'patient_email.email' => 'Debe proporcionar un correo electrónico válido.',
            'start_at.required' => 'Debe seleccionar una fecha y hora.',
            'start_at.date' => 'La fecha proporcionada no es válida.',
            'start_at.after' => 'La cita debe ser para una fecha futura.',
        ];
    }
}
