<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Services\AppointmentService;
use Carbon\Carbon;

class DoctorTest extends TestCase
{
    /** @test */
    public function availability_check_for_weekday()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '12:00']],
                'tuesday' => [],
            ]
        ]);

        $appointmentService = new AppointmentService();

        $mondayMorning = Carbon::now()->next('Monday')->setTime(10, 0);
        $mondayMorningEnd = $mondayMorning->copy()->addMinutes(20);

        $tuesday = Carbon::now()->next('Tuesday')->setTime(10, 0);
        $tuesdayEnd = $tuesday->copy()->addMinutes(20);

        $this->assertTrue($appointmentService->isWithinAvailability($doctor, $mondayMorning, $mondayMorningEnd));
        $this->assertFalse($appointmentService->isWithinAvailability($doctor, $tuesday, $tuesdayEnd));
    }

    /** @test */
    public function availability_check_for_time_slot()
    {
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '12:00']],
            ]
        ]);

        $appointmentService = new AppointmentService();

        // Dentro del horario
        $validTime = Carbon::now()->next('Monday')->setTime(9, 0);
        $validTimeEnd = $validTime->copy()->addMinutes(20);

        // Fuera del horario (tarde)
        $invalidTime = Carbon::now()->next('Monday')->setTime(15, 0);
        $invalidTimeEnd = $invalidTime->copy()->addMinutes(20);

        $this->assertTrue($appointmentService->isWithinAvailability($doctor, $validTime, $validTimeEnd));
        $this->assertFalse($appointmentService->isWithinAvailability($doctor, $invalidTime, $invalidTimeEnd));
    }
}
