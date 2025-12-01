<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Inertia\Inertia;

class PublicController extends Controller
{
    /**
     * Display homepage with list of doctors
     */
    public function index()
    {
        $durationMinutes = (int) env('APPOINTMENT_DURATION_MINUTES', 30);
        
        $doctors = Doctor::active()
            ->orderBy('name')
            ->get()
            ->map(function ($doctor) use ($durationMinutes) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'slug' => $doctor->slug,
                    'specialty' => $doctor->specialty,
                    'bio' => $doctor->bio,
                    'email' => $doctor->email,
                    'phone' => $doctor->phone,
                    'photo' => $doctor->photo,
                    'is_active' => $doctor->is_active,
                    'upcoming_availability' => $doctor->getUpcomingAvailability($durationMinutes),
                ];
            });

        return Inertia::render('Public/Home', [
            'doctors' => $doctors,
            'canLogin' => true,
        ]);
    }

    /**
     * Display doctor profile and available time slots
     */
    public function showDoctor(Doctor $doctor)
    {
        if (!$doctor->is_active) {
            abort(404);
        }

        $durationMinutes = (int) env('APPOINTMENT_DURATION_MINUTES', 30);
        $availability = $doctor->getUpcomingAvailability($durationMinutes);

        return Inertia::render('Public/DoctorProfile', [
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'slug' => $doctor->slug,
                'specialty' => $doctor->specialty,
                'license_number' => $doctor->license_number,
                'bio' => $doctor->bio,
                'photo' => $doctor->photo,
                'email' => $doctor->email,
                'phone' => $doctor->phone,
            ],
            'availability' => $availability,
        ]);
    }

    /**
     * Show appointment booking form
     */
    public function showBookingForm()
    {
        $doctorSlug = request('doctor');
        $startTime = request('start');

        if (!$doctorSlug || !$startTime) {
            return redirect()->route('home')
                ->with('error', 'Información incompleta para agendar la cita.');
        }

        $doctor = Doctor::where('slug', $doctorSlug)->active()->firstOrFail();

        return Inertia::render('Public/BookAppointment', [
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'slug' => $doctor->slug,
                'specialty' => $doctor->specialty,
                'photo' => $doctor->photo,
            ],
            'startTime' => $startTime,
            'durationMinutes' => (int) env('APPOINTMENT_DURATION_MINUTES', 30),
        ]);
    }
}
