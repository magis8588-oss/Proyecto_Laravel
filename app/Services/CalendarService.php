<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;

class CalendarService
{
    /**
     * Generar calendario semanal con disponibilidad y citas
     */
    public function generateWeeklyCalendar(?Doctor $doctor = null, ?Carbon $startDate = null): array
    {
        $startDate = $startDate ?? Carbon::now()->startOfWeek();
        $weekRange = $this->getWeekRange($startDate);

        $calendar = [];

        foreach ($weekRange as $date) {
            $dayOfWeek = strtolower($date->format('l'));
            
            $dayData = [
                'date' => $date->toDateString(),
                'day_name' => $date->format('l'),
                'day_name_es' => $this->getDayNameSpanish($dayOfWeek),
                'slots' => [],
            ];

            if ($doctor) {
                $schedule = $doctor->weekly_schedule ?? [];
                
                if (isset($schedule[$dayOfWeek]) && !empty($schedule[$dayOfWeek])) {
                    $appointmentService = new AppointmentService();
                    $dayData['slots'] = $appointmentService->getAvailableSlots($doctor, $date);
                    
                    // Obtener citas ocupadas
                    $dayData['appointments'] = Appointment::activeForDoctor($doctor->id)
                        ->whereDate('start_at', $date->toDateString())
                        ->orderBy('start_at')
                        ->with('doctor')
                        ->get()
                        ->map(function ($appointment) {
                            return [
                                'id' => $appointment->id,
                                'slug' => $appointment->slug,
                                'patient_name' => $appointment->patient_name,
                                'start_at' => $appointment->start_at->format('Y-m-d H:i:s'),
                                'end_at' => $appointment->end_at->format('Y-m-d H:i:s'),
                                'status' => $appointment->status,
                            ];
                        });
                }
            }

            $calendar[] = $dayData;
        }

        return $calendar;
    }

    /**
     * Obtener rango de fechas de una semana
     */
    public function getWeekRange(Carbon $date): array
    {
        $start = $date->copy()->startOfWeek();
        $dates = [];

        for ($i = 0; $i < 7; $i++) {
            $dates[] = $start->copy()->addDays($i);
        }

        return $dates;
    }

    /**
     * Traducir nombre de día al español
     */
    private function getDayNameSpanish(string $dayOfWeek): string
    {
        $translation = [
            'monday' => 'Lunes',
            'tuesday' => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday' => 'Jueves',
            'friday' => 'Viernes',
            'saturday' => 'Sábado',
            'sunday' => 'Domingo',
        ];

        return $translation[$dayOfWeek] ?? ucfirst($dayOfWeek);
    }
}
