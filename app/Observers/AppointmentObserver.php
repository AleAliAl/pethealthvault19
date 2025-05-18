<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\User;
use Filament\Notifications\Notification;

class AppointmentObserver
{
    public function created(Appointment $appointment)
    {
        // Get all admin users (adjust role-check as needed)
        $admins = User::where('role_id', 1)->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('New Appointment Scheduled')
                ->body("An appointment has been scheduled on {$appointment->AppointmentDate} at {$appointment->AppointmentTime}.")
                ->success()
                ->sendToDatabase($admin);
        }
    }
}
