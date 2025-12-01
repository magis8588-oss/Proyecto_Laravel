<?php

namespace Database\Factories;

use App\Models\DoctorAvailability;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorAvailability>
 */
class DoctorAvailabilityFactory extends Factory
{
    protected $model = DoctorAvailability::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 16);
        $startMinute = fake()->randomElement([0, 30]);
        $durationHours = fake()->numberBetween(2, 4);
        
        $startTime = sprintf('%02d:%02d:00', $startHour, $startMinute);
        $endTime = sprintf('%02d:%02d:00', $startHour + $durationHours, $startMinute);

        return [
            'doctor_id' => Doctor::factory(),
            'day_of_week' => fake()->numberBetween(0, 6),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_active' => true,
        ];
    }

    /**
     * Set specific day of week
     */
    public function dayOfWeek(int $day): static
    {
        return $this->state(fn (array $attributes) => [
            'day_of_week' => $day,
        ]);
    }

    /**
     * Set specific time range
     */
    public function timeRange(string $startTime, string $endTime): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
    }

    /**
     * Inactive availability
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
