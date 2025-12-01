<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            ['name' => 'Retina', 'code' => 'RETINA'],
            ['name' => 'Glaucoma', 'code' => 'GLAUCOMA'],
            ['name' => 'Córnea', 'code' => 'CORNEA'],
            ['name' => 'Cirugía Refractiva', 'code' => 'REFRACTIVA'],
            ['name' => 'Oftalmología Pediátrica', 'code' => 'PEDIATRICA'],
            ['name' => 'Lentes y Refracción', 'code' => 'LENTES'],
            ['name' => 'Oftalmología General', 'code' => 'GENERAL'],
        ];

        foreach ($specialties as $specialty) {
            Specialty::firstOrCreate(
                ['code' => $specialty['code']],
                $specialty
            );
        }
    }
}
