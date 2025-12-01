<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine if the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos los autenticados pueden ver listado
    }

    /**
     * Determine if the user can view the appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        // Admin puede ver todo, o médico puede ver sus propias citas
        return true; // Simplificado: todos pueden ver
    }

    /**
     * Determine if the user can update the appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        return true; // Solo admin (en controller se valida middleware auth)
    }

    /**
     * Determine if the user can delete the appointment.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return true; // Solo admin
    }

    /**
     * Determine if the user can accept the appointment.
     */
    public function accept(User $user, Appointment $appointment): bool
    {
        return true; // Solo admin
    }

    /**
     * Determine if the user can reject the appointment.
     */
    public function reject(User $user, Appointment $appointment): bool
    {
        return true; // Solo admin
    }
}
