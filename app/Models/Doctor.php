<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'license_number',
        'specialty',
        'bio',
        'email',
        'phone',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            if (empty($doctor->slug)) {
                $doctor->slug = Str::slug($doctor->name);
                
                // Ensure unique slug
                $originalSlug = $doctor->slug;
                $count = 1;
                while (static::where('slug', $doctor->slug)->exists()) {
                    $doctor->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    // Route model binding by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships
    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get available time slots for a specific date
    public function getAvailableTimeSlotsForDate($date, $durationMinutes = 30)
    {
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;
        
        $availabilities = $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        if ($availabilities->isEmpty()) {
            return [];
        }

        $slots = [];
        
        foreach ($availabilities as $availability) {
            $start = \Carbon\Carbon::parse($date . ' ' . $availability->start_time);
            $end = \Carbon\Carbon::parse($date . ' ' . $availability->end_time);
            
            while ($start->copy()->addMinutes($durationMinutes)->lte($end)) {
                // Check if slot is not already booked
                $slotEnd = $start->copy()->addMinutes($durationMinutes);
                
                $isBooked = $this->appointments()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where(function ($query) use ($start, $slotEnd) {
                        $query->whereBetween('start_time', [$start, $slotEnd])
                            ->orWhereBetween('end_time', [$start, $slotEnd])
                            ->orWhere(function ($q) use ($start, $slotEnd) {
                                $q->where('start_time', '<=', $start)
                                  ->where('end_time', '>=', $slotEnd);
                            });
                    })
                    ->exists();

                if (!$isBooked && $start->isFuture()) {
                    $slots[] = [
                        'start' => $start->toIso8601String(),
                        'end' => $slotEnd->toIso8601String(),
                        'formatted' => $start->format('h:i A'),
                    ];
                }
                
                $start->addMinutes($durationMinutes);
            }
        }

        return $slots;
    }

    // Get next 7 days with available slots
    public function getUpcomingAvailability($durationMinutes = 30)
    {
        $availability = [];
        $date = now();

        for ($i = 0; $i < 14; $i++) {
            $slots = $this->getAvailableTimeSlotsForDate($date->toDateString(), $durationMinutes);
            
            if (!empty($slots)) {
                foreach ($slots as $slot) {
                    $startTime = \Carbon\Carbon::parse($slot['start']);
                    $availability[] = [
                        'date' => $date->toDateString(),
                        'time' => $startTime->format('H:i'),
                        'dateTime' => $slot['start'],
                        'formatted_time' => $startTime->format('h:i A'),
                    ];
                }
            }

            $date->addDay();
            
            if (count($availability) >= 20) {
                break;
            }
        }

        return $availability;
    }

    // Specialty options for ophthalmology
    public static function getSpecialties()
    {
        return [
            'Retina' => 'Especialista en Retina',
            'Glaucoma' => 'Especialista en Glaucoma',
            'Córnea' => 'Especialista en Córnea',
            'Cirugía Refractiva' => 'Cirugía Refractiva (LASIK, PRK)',
            'Oftalmología Pediátrica' => 'Oftalmología Pediátrica',
            'Lentes y Refracción' => 'Lentes de Contacto y Refracción',
            'Oculoplastia' => 'Cirugía Plástica Ocular',
            'Oftalmología General' => 'Oftalmología General',
        ];
    }
}
