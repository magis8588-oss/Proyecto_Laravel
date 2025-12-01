<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCreated;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentRejected;

class AppointmentTest extends TestCase
{
    /** @test */
    public function public_can_create_valid_appointment()
    {
        Mail::fake();

        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '18:00']]
            ],
            'is_active' => true,
        ]);

        $nextMonday = Carbon::now()->next('Monday')->setTime(10, 0);

        $response = $this->postJson('/appointments', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Juan Pérez',
            'patient_email' => 'juan@example.com',
            'patient_phone' => '555-1234',
            'start_at' => $nextMonday->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('public.index'));
        $this->assertDatabaseHas('appointments', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Juan Pérez',
            'status' => 'pending',
        ]);

        Mail::assertSent(AppointmentCreated::class);
    }

    /** @test */
    public function cannot_create_appointment_with_collision()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '18:00']]
            ],
        ]);

        $nextMonday = Carbon::now()->next('Monday')->setTime(10, 0);
        
        // Crear cita existente
        Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_name' => 'Existente',
            'patient_email' => 'existente@example.com',
            'start_at' => $nextMonday,
            'end_at' => $nextMonday->copy()->addMinutes(20),
            'status' => 'confirmed',
        ]);

        // Intentar crear cita en el mismo horario
        $response = $this->postJson('/appointments', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Juan Pérez',
            'patient_email' => 'juan@example.com',
            'start_at' => $nextMonday->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function cannot_create_appointment_outside_availability()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '12:00']] // Solo mañana
            ],
        ]);

        $nextMonday = Carbon::now()->next('Monday')->setTime(15, 0); // Tarde

        $response = $this->postJson('/appointments', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Juan Pérez',
            'patient_email' => 'juan@example.com',
            'start_at' => $nextMonday->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function cannot_create_appointment_in_past()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);

        $pastDate = Carbon::now()->subDay();

        $response = $this->postJson('/appointments', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Juan Pérez',
            'patient_email' => 'juan@example.com',
            'start_at' => $pastDate->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('start_at');
    }

    /** @test */
    public function admin_can_accept_pending_appointment()
    {
        Mail::fake();

        $user = User::factory()->create();
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.appointments.accept', $appointment->slug));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'confirmed',
        ]);

        Mail::assertSent(AppointmentConfirmed::class);
    }

    /** @test */
    public function admin_can_reject_pending_appointment()
    {
        Mail::fake();

        $user = User::factory()->create();
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.appointments.reject', $appointment->slug));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'rejected',
        ]);

        Mail::assertSent(AppointmentRejected::class);
    }

    /** @test */
    public function admin_can_complete_confirmed_appointment()
    {
        $user = User::factory()->create();
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create(['specialty_id' => $specialty->id]);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.appointments.complete', $appointment->slug));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
        ]);
    }
}
