<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AvailabilityController extends Controller
{
    /**
     * Display the availability management page for a doctor
     */
    public function index(Doctor $doctor)
    {
        $availabilities = $doctor->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return Inertia::render('Admin/Availabilities/Index', [
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'slug' => $doctor->slug,
                'specialty' => $doctor->specialty,
            ],
            'availabilities' => $availabilities,
            'days_of_week' => DoctorAvailability::getDaysOfWeek(),
            'message' => session('message'),
        ]);
    }

    /**
     * Store a new availability slot
     */
    public function store(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
        ]);

        // Check for overlapping availability on the same day
        $overlapping = DoctorAvailability::where('doctor_id', $doctor->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                          ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($overlapping) {
            return back()->with('error', 'Ya existe un horario que se superpone con el seleccionado.');
        }

        $doctor->availabilities()->create($validated);

        return back()->with('message', 'Horario de disponibilidad agregado exitosamente.');
    }

    /**
     * Update the specified availability
     */
    public function update(Request $request, Doctor $doctor, DoctorAvailability $availability)
    {
        if ($availability->doctor_id !== $doctor->id) {
            return back()->with('error', 'Horario no encontrado.');
        }

        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
        ]);

        // Check for overlapping availability (excluding current)
        $overlapping = DoctorAvailability::where('doctor_id', $doctor->id)
            ->where('id', '!=', $availability->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                          ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($overlapping) {
            return back()->with('error', 'Ya existe un horario que se superpone con el seleccionado.');
        }

        $availability->update($validated);

        return back()->with('message', 'Horario actualizado exitosamente.');
    }

    /**
     * Remove the specified availability
     */
    public function destroy(Doctor $doctor, DoctorAvailability $availability)
    {
        if ($availability->doctor_id !== $doctor->id) {
            return back()->with('error', 'Horario no encontrado.');
        }

        $availability->delete();

        return back()->with('message', 'Horario eliminado exitosamente.');
    }
}
