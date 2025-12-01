<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentService
{
    /**
     * Verificar si existe colisión de horarios para un médico
     */
    public function checkCollision(
        int $doctorId,
        Carbon $startAt,
        Carbon $endAt,
        ?int $excludeAppointmentId = null
    ): bool {
        $query = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startAt, $endAt) {
                // Caso 1: La nueva cita empieza durante una existente
                $q->whereBetween('start_at', [$startAt, $endAt->copy()->subSecond()])
                    // Caso 2: La nueva cita termina durante una existente
                    ->orWhereBetween('end_at', [$startAt->copy()->addSecond(), $endAt])
                    // Caso 3: La nueva cita envuelve completamente una existente
                    ->orWhere(function ($subQ) use ($startAt, $endAt) {
                        $subQ->where('start_at', '>=', $startAt)
                            ->where('end_at', '<=', $endAt);
                    })
                    // Caso 4: Una cita existente envuelve completamente la nueva
                    ->orWhere(function ($subQ) use ($startAt, $endAt) {
                        $subQ->where('start_at', '<', $startAt)
                            ->where('end_at', '>', $endAt);
                    });
            });

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return $query->exists();
    }

    /**
     * Verificar si el horario está dentro de la disponibilidad semanal del médico
     */
    public function isWithinAvailability(Doctor $doctor, Carbon $startAt, Carbon $endAt): bool
    {
        $dayOfWeek = strtolower($startAt->format('l'));
        $schedule = $doctor->weekly_schedule ?? [];

        if (!isset($schedule[$dayOfWeek]) || empty($schedule[$dayOfWeek])) {
            return false;
        }

        $timeStart = $startAt->format('H:i');
        $timeEnd = $endAt->format('H:i');

        foreach ($schedule[$dayOfWeek] as $slot) {
            if ($timeStart >= $slot['start'] && $timeEnd <= $slot['end']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calcular hora de fin basado en hora de inicio y duración configurada
     */
    public function calculateEndTime(Carbon $startAt): Carbon
    {
        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);
        return $startAt->copy()->addMinutes($duration);
    }

    /**
     * Obtener slots disponibles para un médico en una fecha específica
     */
    public function getAvailableSlots(Doctor $doctor, Carbon $date): array
    {
        $dayOfWeek = strtolower($date->format('l'));
        $schedule = $doctor->weekly_schedule ?? [];

        if (!isset($schedule[$dayOfWeek]) || empty($schedule[$dayOfWeek])) {
            return [];
        }

        $duration = (int) env('APPOINTMENT_DURATION_MINUTES', 20);
        $availableSlots = [];

        // Obtener citas existentes para ese día
        $existingAppointments = Appointment::activeForDoctor($doctor->id)
            ->whereDate('start_at', $date->toDateString())
            ->orderBy('start_at')
            ->get();

        foreach ($schedule[$dayOfWeek] as $slot) {
            $slotStart = Carbon::parse($date->toDateString() . ' ' . $slot['start']);
            $slotEnd = Carbon::parse($date->toDateString() . ' ' . $slot['end']);

            $currentTime = $slotStart->copy();

            while ($currentTime->copy()->addMinutes($duration) <= $slotEnd) {
                $proposedStart = $currentTime->copy();
                $proposedEnd = $currentTime->copy()->addMinutes($duration);

                // Verificar si este slot está ocupado
                $isOccupied = $existingAppointments->contains(function ($appointment) use ($proposedStart, $proposedEnd) {
                    return !($proposedEnd <= $appointment->start_at || $proposedStart >= $appointment->end_at);
                });

                if (!$isOccupied) {
                    $availableSlots[] = [
                        'start' => $proposedStart->format('Y-m-d H:i:s'),
                        'end' => $proposedEnd->format('Y-m-d H:i:s'),
                    ];
                }

                $currentTime->addMinutes($duration);
            }
        }

        return $availableSlots;
    }
}
