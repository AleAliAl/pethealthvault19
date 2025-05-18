<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Illuminate\Support\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'System Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Appointment Details')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('FirstName')
                            ->required()
                            ->maxLength(255)
                            ->label('First Name'),

                        Forms\Components\TextInput::make('LastName')
                            ->required()
                            ->maxLength(255)
                            ->label('Last Name'),

                        Forms\Components\TextInput::make('OwnerEmail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label('Email'),

                        Forms\Components\Select::make('PetID')
                            ->relationship('pets', 'Name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Pet Name'),
                        DatePicker::make('AppointmentDate')
                            ->label('Appointment Date')
                            ->required()
                            ->displayFormat('m/d/Y')
                            ->minDate(today())
                            ->reactive(),



                        Forms\Components\Select::make('AppointmentTime')
                            ->label('Time Slot')
                            ->required()
                            ->reactive()
                            ->options(function (callable $get, ?\App\Models\Appointment $record): array {
                                $date = $get('AppointmentDate') ?? $record?->AppointmentDate;
                                $selectedTime = $get('AppointmentTime') ?? $record?->AppointmentTime;

                                $allTimes = [
                                    '09:00' => '09:00 AM',
                                    '10:00' => '10:00 AM',
                                    '11:00' => '11:00 AM',
                                    '13:00' => '01:00 PM',
                                    '14:00' => '02:00 PM',
                                    '15:00' => '03:00 PM',
                                ];

                                if (!$date) {
                                    return $allTimes;
                                }

                                $currentRecordId = $record?->AppointmentID;

                                $bookedTimes = Appointment::where('AppointmentDate', $date)
                                    ->when($currentRecordId, fn($q) => $q->where('AppointmentID', '!=', $currentRecordId))
                                    ->pluck('AppointmentTime')
                                    ->toArray();

                                $availableTimes = collect($allTimes)
                                    ->reject(fn($label, $time) => in_array($time, $bookedTimes))
                                    ->toArray();

                                if ($selectedTime && !array_key_exists($selectedTime, $availableTimes)) {
                                    $availableTimes[$selectedTime] = $allTimes[$selectedTime] ?? $selectedTime;
                                }

                                return $availableTimes;
                            })

                            ->afterStateHydrated(function (callable $set, $state, ?\App\Models\Appointment $record) {
                                if (!$state && $record?->AppointmentTime) {
                                    $set('AppointmentTime', $record->AppointmentTime);
                                }
                            })



                            ->rule(function (callable $get, ?Appointment $record) {
                                return function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                                    $date = $get('AppointmentDate') ?? $record?->AppointmentDate;
                                    $recordId = $record?->AppointmentID;

                                    if ($date && $value) {
                                        $existsQuery = Appointment::where('AppointmentDate', $date)
                                            ->where('AppointmentTime', $value);

                                        if ($recordId) {
                                            $existsQuery->where('AppointmentID', '!=', $recordId);
                                        }

                                        if ($existsQuery->exists()) {
                                            $fail('This time slot is already booked for the selected date.');
                                        }
                                    }
                                };
                            }),





                        Forms\Components\Select::make('Description')
                            ->label('Reason for Visit')
                            ->required()
                            ->options([
                                'Vaccination' => 'Vaccination',
                                'Check-up' => 'Check-up',
                                'Grooming' => 'Grooming',
                                'Illness' => 'Illness',
                                'Follow-up' => 'Follow-up',
                                'Surgery Consultation' => 'Surgery Consultation',
                            ]),

                        Forms\Components\Select::make('Status')
                            ->options([
                                'Pending' => 'Pending',
                                'Approved' => 'Approved',
                                'Declined' => 'Declined',
                            ])
                            ->default('Pending')
                            ->required(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('AppointmentID')
                    ->sortable()
                    ->searchable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('FirstName')
                    ->sortable()
                    ->searchable()
                    ->label('First Name'),
                Tables\Columns\TextColumn::make('LastName')
                    ->sortable()
                    ->searchable()
                    ->label('Last Name'),
                Tables\Columns\TextColumn::make('OwnerEmail')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('pets.Name')
                    ->searchable()
                    ->label('Pet Name'),
                Tables\Columns\TextColumn::make('AppointmentDate')
                    ->sortable()
                    ->date('m/d/Y')
                    ->label('Date'),
                Tables\Columns\TextColumn::make('AppointmentTime')
                    ->sortable()
                    ->time('h:i A')
                    ->label('Time'),
                Tables\Columns\TextColumn::make('Description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Description'),
                Tables\Columns\TextColumn::make('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Declined' => 'danger',
                        default => 'warning',
                    })
                    ->sortable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Updated At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Declined' => 'Declined',
                        'Completed' => 'Completed',
                        'Canceled' => 'Canceled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['pets'])
            ->select([
                'AppointmentID',
                'FirstName',
                'LastName',
                'OwnerEmail',
                'PetID',
                'AppointmentDate',
                'AppointmentTime',
                'Description',
                'Status',
                'created_at',
                'updated_at',
            ]);
    }
}
