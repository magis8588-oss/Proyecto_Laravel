<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialties = Doctor::getSpecialties();
        
        return [
            'name' => fake()->name(),
            'license_number' => 'LIC-' . strtoupper(fake()->bothify('??######')),
            'specialty' => fake()->randomElement($specialties),
            'bio' => fake()->paragraph(4),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('+52 ###-###-####'),
            'photo' => null,
            'is_active' => fake()->boolean(90), // 90% active
        ];
    }

    /**
     * Indicate that the doctor is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the doctor is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate the doctor's specialty.
     */
    public function specialty(string $specialty): static
    {
        return $this->state(fn (array $attributes) => [
            'specialty' => $specialty,
        ]);
    }
}
