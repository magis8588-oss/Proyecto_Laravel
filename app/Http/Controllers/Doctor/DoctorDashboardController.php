<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor) {
            abort(403, 'No tienes un perfil de doctor asociado.');
        }

        $query = Appointment::where('doctor_id', $doctor->id)
            ->with('doctor')
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start', '>=', now())
            ->orderBy('start');

        $upcomingAppointments = $query->take(10)->get();
        
        $stats = [
            'pending' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count(),
            'confirmed' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'confirmed')
                ->where('start', '>=', now())
                ->count(),
            'completed' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'completed')
                ->count(),
            'rejected' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'rejected')
                ->count(),
        ];

        return inertia('Doctor/Dashboard', [
            'stats' => $stats,
            'upcomingAppointments' => $upcomingAppointments,
            'doctor' => $doctor,
        ]);
    }

    public function appointments(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor) {
            abort(403, 'No tienes un perfil de doctor asociado.');
        }

        $status = $request->query('status', 'all');
        $dateFilter = $request->query('date');

        $query = Appointment::where('doctor_id', $doctor->id)
            ->with('doctor')
            ->orderBy('start', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateFilter) {
            $date = Carbon::parse($dateFilter);
            $query->whereDate('start', $date);
        }

        $appointments = $query->paginate(15);

        return inertia('Doctor/Appointments', [
            'appointments' => $appointments,
            'filters' => [
                'status' => $status,
                'date' => $dateFilter,
            ],
            'doctor' => $doctor,
        ]);
    }

    public function accept(Appointment $appointment)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'No tienes permiso para aceptar esta cita.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta cita ya no está pendiente.');
        }

        $appointment->update(['status' => 'confirmed']);

        // Cargar la relación doctor antes de enviar el correo
        $appointment->load('doctor');

        Mail::to($appointment->patient_email)->send(
            new AppointmentConfirmed($appointment)
        );

        return redirect()->back()->with('success', 'Cita confirmada exitosamente.');
    }

    public function reject(Appointment $appointment, Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'No tienes permiso para rechazar esta cita.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta cita ya no está pendiente.');
        }

        $appointment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason', 'Sin razón especificada'),
        ]);

        // Cargar la relación doctor antes de enviar el correo
        $appointment->load('doctor');

        Mail::to($appointment->patient_email)->send(
            new AppointmentRejected($appointment)
        );

        return redirect()->back()->with('success', 'Cita rechazada.');
    }

    public function complete(Appointment $appointment)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'No tienes permiso para completar esta cita.');
        }

        if ($appointment->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Solo se pueden completar citas confirmadas.');
        }

        $appointment->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Cita marcada como completada.');
    }
}
