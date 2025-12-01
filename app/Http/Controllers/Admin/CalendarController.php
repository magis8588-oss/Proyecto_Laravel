<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use Inertia\Inertia;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the appointment calendar
     */
    public function index()
    {
        $doctorSlug = request('doctor');
        
        $doctors = Doctor::active()->orderBy('name')->get(['id', 'name', 'slug', 'specialty']);
        
        $selectedDoctor = null;
        $appointments = [];
        
        if ($doctorSlug) {
            $selectedDoctor = Doctor::where('slug', $doctorSlug)->firstOrFail();
            
            // Get appointments for selected doctor (next 30 days)
            $startDate = now()->startOfDay();
            $endDate = now()->addDays(30)->endOfDay();
            
            $appointments = Appointment::where('doctor_id', $selectedDoctor->id)
                ->whereBetween('start_time', [$startDate, $endDate])
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->with('doctor')
                ->orderBy('start_time')
                ->get()
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'title' => $appointment->patient_name,
                        'start' => $appointment->start_time->toIso8601String(),
                        'end' => $appointment->end_time->toIso8601String(),
                        'status' => $appointment->status,
                        'status_label' => $appointment->status_label,
                        'status_color' => $appointment->status_color,
                        'patient_name' => $appointment->patient_name,
                        'patient_email' => $appointment->patient_email,
                        'patient_phone' => $appointment->patient_phone,
                        'reason' => $appointment->reason,
                    ];
                });
                
            // Get doctor's availability for the calendar
            $availabilities = $selectedDoctor->availabilities()
                ->where('is_active', true)
                ->get()
                ->map(function ($availability) {
                    return [
                        'day_of_week' => $availability->day_of_week,
                        'day_name' => $availability->day_name,
                        'start_time' => $availability->start_time,
                        'end_time' => $availability->end_time,
                    ];
                });
        }

        return Inertia::render('Admin/Calendar/Index', [
            'doctors' => $doctors,
            'selectedDoctor' => $selectedDoctor ? [
                'id' => $selectedDoctor->id,
                'name' => $selectedDoctor->name,
                'slug' => $selectedDoctor->slug,
                'specialty' => $selectedDoctor->specialty,
                'availabilities' => $availabilities ?? [],
            ] : null,
            'appointments' => $appointments,
        ]);
    }
}
