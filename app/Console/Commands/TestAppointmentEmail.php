<?php

namespace App\Console\Commands;

use App\Mail\AppointmentCreated;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestAppointmentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:appointment-email {appointmentId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test appointment confirmation email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appointmentId = $this->argument('appointmentId') ?? Appointment::latest()->first()?->id;

        if (!$appointmentId) {
            $this->error('No appointments found in database. Please create one first.');
            return 1;
        }

        $appointment = Appointment::with('doctor')->find($appointmentId);

        if (!$appointment) {
            $this->error("Appointment with ID {$appointmentId} not found.");
            return 1;
        }

        $this->info("Sending test email for appointment #{$appointment->id}...");
        $this->info("Patient: {$appointment->patient_name}");
        $this->info("Email: {$appointment->patient_email}");
        $this->info("Doctor: {$appointment->doctor->name}");
        $this->info("Date: {$appointment->start_time->format('Y-m-d H:i')}");
        $this->newLine();

        try {
            Mail::to($appointment->patient_email)->send(new AppointmentCreated($appointment));
            
            $this->info('✅ Email sent successfully!');
            $this->info('Check storage/logs/laravel.log to see the email content');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error sending email: ' . $e->getMessage());
            return 1;
        }
    }
}
