<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialtyFactory extends Factory
{
    public function definition(): array
    {
        $specialties = [
            ['name' => 'Oftalmología', 'code' => 'OFTALMO'],
            ['name' => 'Optometría', 'code' => 'OPTOM'],
            ['name' => 'Cirugía Ocular', 'code' => 'CIRUGIA'],
            ['name' => 'Retinología', 'code' => 'RETINA'],
            ['name' => 'Glaucoma', 'code' => 'GLAUCO'],
        ];

        $specialty = $this->faker->randomElement($specialties);

        return [
            'name' => $specialty['name'],
            'code' => $specialty['code'],
        ];
    }
}
