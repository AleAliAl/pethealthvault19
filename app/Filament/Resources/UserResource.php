<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Barangay;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'firstname';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('firstname')
                        ->required()
                        ->maxLength(255)
                        ->label('Firstname'),

                    Forms\Components\TextInput::make('lastname')
                        ->required()
                        ->maxLength(255)
                        ->label('Lastname'),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->label('Email'),

                    Select::make('barangay_id')
                        ->label('Barangay')
                        ->options(fn () => Barangay::orderBy('name')->pluck('name', 'id')->map(fn($name) => 'Brgy. ' . $name))
                        ->searchable()
                        ->preload()
                        ->placeholder('Select Barangay'),

                    Forms\Components\TextInput::make('phone_number')
                        ->tel()
                        ->label('Phone Number')
                        ->maxLength(13)
                        ->regex('/^(09\d{9}|(\+639)\d{9}|(\(02\)\d{7}|(\+632)\d{7}))$/')
                        ->placeholder('e.g., +639123456789 or 09123456789')
                        ->nullable()
                        ->helperText('Enter a valid Philippine number.'),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(Page $livewire) => $livewire instanceof Pages\CreateUser)
                        ->maxLength(255)
                        ->label('Password'),

                    Select::make('role_id')
                        ->relationship('roles', 'name')
                        ->label('Role')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->placeholder('Select a role'),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable()->label('ID'),
                Tables\Columns\TextColumn::make('firstname')->sortable()->searchable()->label('Firstname'),
                Tables\Columns\TextColumn::make('lastname')->sortable()->searchable()->label('Lastname'),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable()->label('Email'),
                Tables\Columns\TextColumn::make('barangay.name')
                    ->label('Barangay')
                    ->formatStateUsing(fn($state) => $state ? 'Brgy. ' . $state : '-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with('barangay') 
            ->select([
                'id',
                'firstname',
                'lastname',
                'email',
                'barangay_id',
                'phone_number',
                'role_id',
                'created_at',
                'updated_at',
            ]);
    }
}
