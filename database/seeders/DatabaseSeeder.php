<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Appointment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@clinica.com',
            'password' => bcrypt('password'),
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Usuario Test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ophthalmology Doctors
        |--------------------------------------------------------------------------
        */

        // Create specialized doctors with realistic data
        $doctors = [];

        // Dr. Retina Specialist
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dra. María Fernández González',
            'license_number' => 'LIC-RETIN001',
            'specialty' => 'Retina y Vítreo',
            'bio' => 'Especialista en enfermedades de retina con más de 15 años de experiencia. Subespecialidad en retinopatía diabética y degeneración macular. Certificada por el Consejo Mexicano de Oftalmología.',
            'email' => 'maria.fernandez@clinica.com',
            'phone' => '+52 555-123-4567',
        ]);

        // Dr. Glaucoma Specialist
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dr. Roberto Martínez Cruz',
            'license_number' => 'LIC-GLAUC001',
            'specialty' => 'Glaucoma',
            'bio' => 'Experto en diagnóstico y tratamiento de glaucoma. Especialista en cirugías mínimamente invasivas (MIGS) y trabeculectomías. Miembro de la Sociedad Mexicana de Glaucoma.',
            'email' => 'roberto.martinez@clinica.com',
            'phone' => '+52 555-234-5678',
        ]);

        // Dr. Pediatric Specialist
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dra. Ana Patricia López Ruiz',
            'license_number' => 'LIC-PEDIA001',
            'specialty' => 'Oftalmología Pediátrica',
            'bio' => 'Dedicada al cuidado oftalmológico de niños y adolescentes. Especialista en estrabismo, ambliopía y enfermedades congénitas oculares. Certificación internacional en oftalmología pediátrica.',
            'email' => 'ana.lopez@clinica.com',
            'phone' => '+52 555-345-6789',
        ]);

        // Dr. Refractive Surgery
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dr. Carlos Hernández Pérez',
            'license_number' => 'LIC-REFRA001',
            'specialty' => 'Cirugía Refractiva',
            'bio' => 'Cirujano experto en LASIK, PRK y cirugía refractiva con lente intraocular. Más de 5000 cirugías realizadas. Certificado en uso de tecnología femtosegundo.',
            'email' => 'carlos.hernandez@clinica.com',
            'phone' => '+52 555-456-7890',
        ]);

        // Dr. Cornea Specialist
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dr. Jorge Luis Ramírez Silva',
            'license_number' => 'LIC-CORNE001',
            'specialty' => 'Córnea y Segmento Anterior',
            'bio' => 'Especialista en trasplante de córnea, queratocono y enfermedades de superficie ocular. Fellow en cornea por la Universidad de Harvard.',
            'email' => 'jorge.ramirez@clinica.com',
            'phone' => '+52 555-567-8901',
        ]);

        // Dr. General Ophthalmologist
        $doctors[] = Doctor::factory()->active()->create([
            'name' => 'Dra. Laura Sofía García Vega',
            'license_number' => 'LIC-GENER001',
            'specialty' => 'Oftalmología General',
            'bio' => 'Oftalmóloga general con amplia experiencia en consulta, diagnóstico y tratamiento de las patologías oculares más frecuentes. Enfoque en medicina preventiva.',
            'email' => 'laura.garcia@clinica.com',
            'phone' => '+52 555-678-9012',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Doctor Availabilities
        |--------------------------------------------------------------------------
        */

        foreach ($doctors as $doctor) {
            // Monday to Friday: Morning shift (9:00 - 13:00)
            for ($day = 1; $day <= 5; $day++) {
                DoctorAvailability::factory()->create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '13:00:00',
                    'is_active' => true,
                ]);
            }

            // Monday, Wednesday, Friday: Afternoon shift (15:00 - 19:00)
            foreach ([1, 3, 5] as $day) {
                DoctorAvailability::factory()->create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                    'start_time' => '15:00:00',
                    'end_time' => '19:00:00',
                    'is_active' => true,
                ]);
            }

            // Saturday: Morning shift only (9:00 - 14:00)
            DoctorAvailability::factory()->create([
                'doctor_id' => $doctor->id,
                'day_of_week' => 6,
                'start_time' => '09:00:00',
                'end_time' => '14:00:00',
                'is_active' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sample Appointments
        |--------------------------------------------------------------------------
        */

        foreach ($doctors as $doctor) {
            // Pending appointments (awaiting confirmation)
            Appointment::factory()->count(3)->pending()->create([
                'doctor_id' => $doctor->id,
            ]);

            // Confirmed appointments (upcoming)
            Appointment::factory()->count(5)->confirmed()->create([
                'doctor_id' => $doctor->id,
            ]);

            // Completed appointments (past)
            Appointment::factory()->count(4)->completed()->create([
                'doctor_id' => $doctor->id,
            ]);

            // Some rejected appointments
            Appointment::factory()->count(1)->rejected()->create([
                'doctor_id' => $doctor->id,
            ]);
        }

        $this->command->info('✅ Database seeded successfully with ophthalmology clinic data!');
        $this->command->info('📧 Admin: admin@clinica.com / password');
        $this->command->info('👨‍⚕️ ' . count($doctors) . ' doctors created with schedules');
        $this->command->info('📅 Sample appointments created for all doctors');
    }
}
