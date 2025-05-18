<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Mail\AppointmentNotification;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Appointment Updated';
        
    }

    protected function afterSave(): void
    {
        // Send mail after saving
        try {
            Mail::to($this->record->OwnerEmail)->send(new AppointmentNotification($this->record));

            Notification::make()
                ->title("Email Sent")
                ->body("Client has been notified of the appointment update.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title("Email Failed")
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
