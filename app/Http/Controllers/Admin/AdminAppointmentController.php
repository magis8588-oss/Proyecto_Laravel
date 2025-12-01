<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAppointmentController extends Controller
{
    /**
     * Display a listing of appointments with filters
     */
    public function index(Request $request)
    {
        $query = Appointment::with('doctor');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by doctor
        if ($request->has('doctor_id') && $request->doctor_id !== 'all') {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('start_time', '<=', $request->end_date);
        }

        // Order by start time
        $appointments = $query->orderBy('start_time', 'desc')->get();

        $doctors = Doctor::orderBy('name')->get(['id', 'name', 'specialty']);

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'filters' => $request->only(['status', 'doctor_id', 'start_date', 'end_date']),
            'message' => session('message'),
        ]);
    }

    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        $appointment->load('doctor');

        return Inertia::render('Admin/Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * Confirm an appointment
     */
    public function confirm(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Solo se pueden confirmar citas pendientes.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->confirm($validated['admin_notes'] ?? null);

        return back()->with('message', 'Cita confirmada exitosamente. Se ha enviado un correo al paciente.');
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
            'admin_notes' => 'required|string|max:1000',
        ]);

        $appointment->reject($validated['admin_notes']);

        return back()->with('message', 'Cita rechazada. Se ha notificado al paciente.');
    }

    /**
     * Mark appointment as completed
     */
    public function complete(Appointment $appointment)
    {
        if ($appointment->status !== 'confirmed') {
            return back()->with('error', 'Solo se pueden completar citas confirmadas.');
        }

        $appointment->complete();

        return back()->with('message', 'Cita marcada como completada.');
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'No se puede cancelar esta cita.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->admin_notes = $validated['admin_notes'] ?? 'Cancelada por el administrador';
        $appointment->cancel();

        return back()->with('message', 'Cita cancelada exitosamente.');
    }

    /**
     * Delete an appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('message', 'Cita eliminada exitosamente.');
    }
}
