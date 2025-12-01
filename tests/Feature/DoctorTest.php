<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;

class DoctorTest extends TestCase
{
    /** @test */
    public function admin_can_create_doctor()
    {
        $user = User::factory()->create();
        $specialty = Specialty::factory()->create(['code' => 'TEST']);

        $response = $this->actingAs($user)->postJson(route('admin.doctors.store'), [
            'name' => 'Dr. New Doctor',
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [
                'monday' => [['start' => '08:00', 'end' => '12:00']]
            ],
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.doctors.index'));
        $this->assertDatabaseHas('doctors', [
            'name' => 'Dr. New Doctor',
            'slug' => 'dr-new-doctor',
            'specialty_id' => $specialty->id,
        ]);
    }

    /** @test */
    public function slug_is_generated_automatically()
    {
        $specialty = Specialty::factory()->create();
        
        $doctor = Doctor::create([
            'name' => 'Dr. Test Doctor',
            'specialty_id' => $specialty->id,
            'weekly_schedule' => [],
            'is_active' => true,
        ]);

        $this->assertEquals('dr-test-doctor', $doctor->slug);
    }

    /** @test */
    public function active_scope_filters_correctly()
    {
        $specialty = Specialty::factory()->create();
        
        Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'is_active' => true
        ]);
        Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'is_active' => true
        ]);
        Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'is_active' => false
        ]);

        $activeDoctors = Doctor::active()->get();

        $this->assertEquals(2, $activeDoctors->count());
    }
}
