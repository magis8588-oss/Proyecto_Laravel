<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\AppointmentCreated;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentRejected;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->slug)) {
                $appointment->slug = Str::slug($appointment->patient_name . '-' . now()->format('YmdHis'));
            }
        });
    }

    protected $fillable = [
        'slug',
        'doctor_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'reason',
        'start_time',
        'end_time',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationships
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', now());
    }

    // Status methods
    public function confirm($notes = null)
    {
        $this->status = 'confirmed';
        if ($notes) {
            $this->admin_notes = $notes;
        }
        $this->save();

        // Send confirmation email
        Mail::to($this->patient_email)->send(new AppointmentConfirmed($this));

        return $this;
    }

    public function reject($notes = null)
    {
        $this->status = 'rejected';
        if ($notes) {
            $this->admin_notes = $notes;
        }
        $this->save();

        // Send rejection email
        Mail::to($this->patient_email)->send(new AppointmentRejected($this));

        return $this;
    }

    public function complete()
    {
        $this->status = 'completed';
        $this->save();

        return $this;
    }

    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();

        return $this;
    }

    // Check if appointment overlaps with existing ones
    public static function hasOverlap($doctorId, $startTime, $endTime, $excludeId = null)
    {
        $query = static::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($subQ) use ($startTime, $endTime) {
                        $subQ->where('start_time', '<=', $startTime)
                             ->where('end_time', '>=', $endTime);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'rejected' => 'red',
            'completed' => 'blue',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmada',
            'rejected' => 'Rechazada',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            default => 'Desconocido',
        };
    }
}
