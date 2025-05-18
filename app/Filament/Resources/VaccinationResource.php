<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VaccinationResource\Pages;
use App\Models\Vaccination;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class VaccinationResource extends Resource
{
    protected static ?string $model = Vaccination::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Medical Records';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('PetID')
                    ->relationship('pets', 'Name') 
                    ->searchable()
                    ->required()
                    ->label('Pet'),

                DatePicker::make('RecordDate')
                    ->required()
                    ->label('Record Date'),

                TextInput::make('VaccinationName')
                    ->required()
                    ->maxLength(100)
                    ->label('Vaccination Name'),

                DatePicker::make('NextDueDate')
                    ->nullable()
                    ->label('Next Due Date'),

                TextInput::make('Veterinarian')
                    ->required()
                    ->maxLength(100)
                    ->label('Veterinarian'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('VaccinationID')->sortable(),
                TextColumn::make('pets.Name')->sortable()->label('Pet Name'), 
                TextColumn::make('RecordDate')->date()->sortable(),
                TextColumn::make('VaccinationName')->sortable()->searchable(),
                TextColumn::make('NextDueDate')->date()->sortable(),
                TextColumn::make('Veterinarian')->sortable(),
                TextColumn::make('created_at')->dateTime('M d, Y')->label('Created At'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVaccinations::route('/'),
            'create' => Pages\CreateVaccination::route('/create'),
            'edit' => Pages\EditVaccination::route('/{record}/edit'),
        ];
    }
}
