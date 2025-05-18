<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoteResource\Pages;
use App\Models\Note;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Laravel\Prompts\Note as PromptsNote;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 5;
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

                Textarea::make('NoteContent')
                    ->required()
                    ->label('Note Content'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('NoteID')->sortable(),
                TextColumn::make('pets.Name')->sortable()->label('Pet Name'),
                TextColumn::make('NoteContent')->limit(50)->searchable(),
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
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->select(['NoteID', 'PetID', 'NoteContent', 'created_at'])
            ->with('pets:PetID,Name');
    }
}
