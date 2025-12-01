<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Se valida en policy o middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $doctor = $this->route('doctor'); // Obtener doctor del route binding

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('doctors', 'slug')->ignore($doctor->id)->where(function ($query) {
                    $slug = Str::slug($this->input('name'));
                    return $query->where('slug', $slug);
                }),
            ],
            'specialty_id' => 'required|exists:specialties,id',
            'weekly_schedule' => 'required|array',
            'weekly_schedule.*' => 'array',
            'weekly_schedule.*.*.start' => 'required_with:weekly_schedule.*|date_format:H:i',
            'weekly_schedule.*.*.end' => 'required_with:weekly_schedule.*|date_format:H:i|after:weekly_schedule.*.*.start',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del médico es obligatorio.',
            'name.unique' => 'Ya existe un médico con ese nombre.',
            'specialty_id.required' => 'Debe seleccionar una especialidad.',
            'specialty_id.exists' => 'La especialidad seleccionada no existe.',
            'weekly_schedule.required' => 'Debe definir el horario semanal.',
            'weekly_schedule.array' => 'El horario semanal debe ser un array.',
            'weekly_schedule.*.*.start.required_with' => 'Debe especificar la hora de inicio.',
            'weekly_schedule.*.*.start.date_format' => 'La hora de inicio debe estar en formato HH:MM.',
            'weekly_schedule.*.*.end.required_with' => 'Debe especificar la hora de fin.',
            'weekly_schedule.*.*.end.date_format' => 'La hora de fin debe estar en formato HH:MM.',
            'weekly_schedule.*.*.end.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ];
    }
}
