<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors
     */
    public function index()
    {
        $doctors = Doctor::orderBy('name')->get();

        return Inertia::render('Admin/Doctors/Index', [
            'doctors' => $doctors,
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new doctor
     */
    public function create()
    {
        return Inertia::render('Admin/Doctors/Create', [
            'specialties' => Doctor::getSpecialties(),
        ]);
    }

    /**
     * Store a newly created doctor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:doctors',
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'email' => 'required|email|max:255|unique:doctors',
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')
            ->with('message', 'Médico creado exitosamente.');
    }

    /**
     * Display the specified doctor
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('availabilities', 'appointments');

        return Inertia::render('Admin/Doctors/Show', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * Show the form for editing the specified doctor
     */
    public function edit(Doctor $doctor)
    {
        return Inertia::render('Admin/Doctors/Edit', [
            'doctor' => $doctor,
            'specialties' => Doctor::getSpecialties(),
        ]);
    }

    /**
     * Update the specified doctor
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:doctors,license_number,' . $doctor->id,
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'email' => 'required|email|max:255|unique:doctors,email,' . $doctor->id,
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        // Update slug if name changed
        if ($doctor->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Doctor::where('slug', $validated['slug'])->where('id', '!=', $doctor->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')
            ->with('message', 'Médico actualizado exitosamente.');
    }

    /**
     * Remove the specified doctor
     */
    public function destroy(Doctor $doctor)
    {
        // Check if doctor has future appointments
        $hasFutureAppointments = $doctor->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '>', now())
            ->exists();

        if ($hasFutureAppointments) {
            return back()->with('error', 'No se puede eliminar el médico porque tiene citas futuras programadas.');
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('message', 'Médico eliminado exitosamente.');
    }
}
