<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationResource\Pages;
use App\Models\Medication;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class MedicationResource extends Resource
{
    protected static ?string $model = Medication::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Medical Records';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('ProductName')
                ->required()
                ->maxLength(255),

            TextInput::make('Dosage')
                ->required(),

            TextInput::make('Frequency')
                ->required(),

            TextInput::make('DurationDays')
                ->numeric()
                ->nullable()
                ->minValue(0),

            TextInput::make('Price')
                ->numeric()
                ->prefix('₱')
                ->nullable(),

            TextInput::make('Type')
                ->maxLength(100)
                ->nullable(),

            TextInput::make('StockQuantity')
                ->numeric()
                ->minValue(0)
                ->default(0),

            DatePicker::make('ExpirationDate')
                ->nullable()
                ->label('Expiry Date'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('MedicationID')->sortable()->label('ID'),
            TextColumn::make('ProductName')->sortable()->searchable(),
            TextColumn::make('Dosage')->sortable(),
            TextColumn::make('Frequency')->sortable(),
            TextColumn::make('DurationDays')->sortable()->label('Days'),
            TextColumn::make('Price')->money('PHP', true),
            TextColumn::make('Type'),
            TextColumn::make('StockQuantity')->label('Stock'),
            TextColumn::make('ExpirationDate')->date()->label('Expiry'),
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
            'index' => Pages\ListMedications::route('/'),
            'create' => Pages\CreateMedication::route('/create'),
            'edit' => Pages\EditMedication::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->select([
            'MedicationID',
            'ProductName',
            'Dosage',
            'Frequency',
            'DurationDays',
            'Price',
            'Type',
            'StockQuantity',
            'ExpirationDate',
            'created_at',
        ]);
    }
}
