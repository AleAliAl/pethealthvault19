<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        
    }

    
    public function boot()
    {
        Appointment::observe(AppointmentObserver::class);
        
    }


}
