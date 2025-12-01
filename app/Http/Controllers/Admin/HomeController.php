<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the admin dashboard home
     * Shows summary of pending appointments and upcoming confirmed appointments
     */
    public function index(Request $request)
    {
        $doctorId = $request->get('doctor_id', 'all');
        
        // Get all doctors for filter
        $doctors = Doctor::active()->orderBy('name')->get(['id', 'name', 'specialty']);
        
        // Base query
        $pendingQuery = Appointment::with('doctor');
        $upcomingQuery = Appointment::with('doctor');
        
        // Apply doctor filter
        if ($doctorId !== 'all') {
            $pendingQuery->where('doctor_id', $doctorId);
            $upcomingQuery->where('doctor_id', $doctorId);
        }
        
        // Pending appointments
        $pendingAppointments = $pendingQuery
            ->where('status', 'pending')
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();
        
        // Upcoming confirmed appointments (next 7 days)
        $upcomingAppointments = $upcomingQuery
            ->where('status', 'confirmed')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(7))
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();
        
        // Statistics
        $statsQuery = Appointment::query();
        if ($doctorId !== 'all') {
            $statsQuery->where('doctor_id', $doctorId);
        }
        
        $stats = [
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'confirmed' => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'completed' => (clone $statsQuery)->where('status', 'completed')->count(),
            'rejected' => (clone $statsQuery)->where('status', 'rejected')->count(),
            'total_today' => (clone $statsQuery)
                ->whereDate('start_time', today())
                ->whereIn('status', ['confirmed', 'completed'])
                ->count(),
            'total_this_week' => (clone $statsQuery)
                ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->whereIn('status', ['confirmed', 'completed'])
                ->count(),
        ];
        
        return Inertia::render('Home', [
            'pendingAppointments' => $pendingAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'doctors' => $doctors,
            'stats' => $stats,
            'filters' => [
                'doctor_id' => $doctorId,
            ],
            'message' => session('message'),
        ]);
    }
}
