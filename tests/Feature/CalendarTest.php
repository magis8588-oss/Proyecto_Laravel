<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;

class CalendarTest extends TestCase
{
    /** @test */
    public function admin_can_view_calendar()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.calendar'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Admin/Calendar'));
    }

    /** @test */
    public function calendar_can_filter_by_doctor()
    {
        $user = User::factory()->create();
        $specialty = Specialty::factory()->create();
        $doctor = Doctor::factory()->create([
            'specialty_id' => $specialty->id,
            'slug' => 'test-doctor'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.calendar', ['doctor' => 'test-doctor']));

        $response->assertOk();
    }
}
