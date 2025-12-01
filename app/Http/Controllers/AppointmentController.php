<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Mail\AppointmentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Store a new appointment (public route)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'required|string|max:20',
            'reason' => 'nullable|string|max:1000',
            'start_time' => 'required|date|after:now',
        ]);

        // Calculate end time based on duration
        $durationMinutes = (int) env('APPOINTMENT_DURATION_MINUTES', 30);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($durationMinutes);

        // Check if doctor is active
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        if (!$doctor->is_active) {
            return back()->with('error', 'El médico seleccionado no está disponible.');
        }

        // Check for overlapping appointments
        if (Appointment::hasOverlap($validated['doctor_id'], $startTime, $endTime)) {
            return back()->with('error', 'El horario seleccionado ya no está disponible. Por favor, seleccione otro horario.');
        }

        // Create appointment
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'],
            'reason' => $validated['reason'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        // Send email notification
        Mail::to($appointment->patient_email)->send(new AppointmentCreated($appointment));

        return redirect()->route('home')
            ->with('success', 'Su cita ha sido registrada exitosamente. Recibirá un correo de confirmación pronto.');
    }
}
