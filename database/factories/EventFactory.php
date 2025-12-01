<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "event_name" => fake()->unique()->words(5, true),
            "event_date" => fake()->dateTimeBetween('now', '+1 year'),
            "event_speaker_name" => fake()->name(),
            "event_is_virtual" => fake()->boolean(),
            "fk_venue_event" => null,
        ];
    }
}