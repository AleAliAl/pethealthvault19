<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangayResource\Pages;
use App\Models\Barangay;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Tables\Table;


class BarangayResource extends Resource
{
    protected static ?string $model = Barangay::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->label('Barangay Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter barangay name')
                    ->columnSpan('full'),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Barangay Name')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangays::route('/'),
            'create' => Pages\CreateBarangay::route('/create'),
            'edit' => Pages\EditBarangay::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select(['id', 'name', 'created_at']);
    }
}
