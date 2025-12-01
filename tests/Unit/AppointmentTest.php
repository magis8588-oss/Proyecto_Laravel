<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Carbon\Carbon;

class AppointmentTest extends TestCase
{
    /** @test */
    public function end_at_is_calculated_automatically()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);
        $startAt = Carbon::now()->addDay()->setTime(10, 0);

        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => 'Test Patient',
            'patient_email' => 'test@example.com',
            'start_at' => $startAt,
            // No especificamos end_at
            'status' => 'pending',
        ]);

        $this->assertNotNull($appointment->end_at);
        $this->assertEquals(20, $appointment->start_at->diffInMinutes($appointment->end_at));
    }

    /** @test */
    public function slug_is_generated_as_uuid()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);

        $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id]);

        $this->assertNotEmpty($appointment->slug);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $appointment->slug
        );
    }

    /** @test */
    public function active_for_doctor_scope_filters_correctly()
    {
        $specialty = Specialty::factory()->create();
        $doctor1 = Doctor::factory()->create(['specialty_id' => $specialty->id]);
        $doctor2 = Doctor::factory()->create(['specialty_id' => $specialty->id]);

        // Citas activas para doctor1
        Appointment::factory()->create([
            'doctor_id' => $doctor1->id,
            'status' => 'pending'
        ]);
        Appointment::factory()->create([
            'doctor_id' => $doctor1->id,
            'status' => 'confirmed'
        ]);

        // Citas no activas
        Appointment::factory()->create([
            'doctor_id' => $doctor1->id,
            'status' => 'completed'
        ]);
        Appointment::factory()->create([
            'doctor_id' => $doctor2->id,
            'status' => 'pending'
        ]);

        $activeAppointments = Appointment::activeForDoctor($doctor1->id)->get();

        $this->assertEquals(2, $activeAppointments->count());
    }
}
