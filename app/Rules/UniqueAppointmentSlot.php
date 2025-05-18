<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Appointment;

class UniqueAppointmentSlot implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = request()->input('AppointmentDate');
        $count = Appointment::where('AppointmentDate', $date)
            ->where('AppointmentTime', $value)
            ->count();

        if ($count > 0) {
            $fail('This time slot is already booked for the selected date.');
        }
    }
}
