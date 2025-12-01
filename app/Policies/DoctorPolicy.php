<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    /**
     * Determine if the user can view any doctors.
     */
    public function viewAny(User $user): bool
    {
        return true; // Admin puede ver
    }

    /**
     * Determine if the user can view the doctor.
     */
    public function view(User $user, Doctor $doctor): bool
    {
        return true;
    }

    /**
     * Determine if the user can create doctors.
     */
    public function create(User $user): bool
    {
        return true; // Solo admin
    }

    /**
     * Determine if the user can update the doctor.
     */
    public function update(User $user, Doctor $doctor): bool
    {
        return true; // Solo admin
    }

    /**
     * Determine if the user can delete the doctor.
     */
    public function delete(User $user, Doctor $doctor): bool
    {
        return true; // Solo admin
    }
}
