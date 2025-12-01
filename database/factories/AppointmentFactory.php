<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('now', '+30 days');
        $durationMinutes = env('APPOINTMENT_DURATION_MINUTES', 30);
        $endTime = (clone $startTime)->modify("+{$durationMinutes} minutes");

        return [
            'doctor_id' => Doctor::factory(),
            'patient_name' => fake()->name(),
            'patient_email' => fake()->safeEmail(),
            'patient_phone' => fake()->numerify('+52 ###-###-####'),
            'reason' => fake()->randomElement([
                'Revisión general de la vista',
                'Control de glaucoma',
                'Examen de retina',
                'Consulta por miopía',
                'Revisión de lentes de contacto',
                'Dolor ocular',
                'Visión borrosa',
                'Consulta pediátrica',
                'Revisión post-operatoria',
                'Evaluación para cirugía refractiva',
            ]),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
            'admin_notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Set status to pending
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'admin_notes' => null,
        ]);
    }

    /**
     * Set status to confirmed
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'admin_notes' => 'Cita confirmada. Por favor llegar 10 minutos antes.',
        ]);
    }

    /**
     * Set status to rejected
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'admin_notes' => 'Horario no disponible. Por favor seleccionar otro horario.',
        ]);
    }

    /**
     * Set status to completed
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_time' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }

    /**
     * Set status to cancelled
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'admin_notes' => 'Cita cancelada por el paciente.',
        ]);
    }

    /**
     * Set for specific doctor
     */
    public function forDoctor(Doctor $doctor): static
    {
        return $this->state(fn (array $attributes) => [
            'doctor_id' => $doctor->id,
        ]);
    }
}
