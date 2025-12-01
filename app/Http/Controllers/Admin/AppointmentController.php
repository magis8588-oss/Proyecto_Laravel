<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['doctor']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('start_time', '<=', $request->end_date);
        }

        // Order by appointment date
        $query->orderBy('start_time', 'desc');

        // Paginate results
        $appointments = $query->paginate(15)->withQueryString();

        // Get all doctors for filter dropdown
        $doctors = Doctor::where('is_active', true)->get();

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'filters' => $request->only(['status', 'doctor', 'start_date', 'end_date'])
        ]);
    }

    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor']);

        return Inertia::render('Admin/Appointments/Show', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Accept/Confirm an appointment
     */
    public function accept(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Solo se pueden confirmar citas pendientes.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        $appointment->confirm($validated['notes'] ?? null);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'La cita ha sido confirmada y se ha enviado un correo al paciente.');
    }

    /**
     * Reject an appointment
     */
    public function reject(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Solo se pueden rechazar citas pendientes.');
        }

        $validated = $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $appointment->reject($validated['notes']);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'La cita ha sido rechazada y se ha notificado al paciente.');
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Solo se pueden cancelar citas pendientes o confirmadas.');
        }

        $appointment->cancel();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'La cita ha sido cancelada exitosamente.');
    }
}
