<?php

namespace App\Filament\Resources;

use Filament\Forms;

use App\Models\City;
use App\Models\User;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Gestión de Empleados';

    //protected static ?int $navigationSort = 1;

    //Pluralizar nombre de los Modelos
    protected static ?string $modelLabel = 'Empleado';
    protected static ?string $pluralModelLabel = 'Empleados';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Personal')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    // Forms\Components\DateTimePicker::make('email_verified_at')
                    //     ->label('Verificado'),
                    Forms\Components\TextInput::make('password')
                        ->label('Clave')
                        //->hiddenOn('edit')
                        ->password()
                        ->revealable()
                        ->required(),
                ]),

                Section::make('Datos de Localización')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('address')
                    ->columnSpan($span = 2)
                        ->label('Direccion'),
                    Forms\Components\TextInput::make('postal_code')
                    ->columnSpan($span = 1)
                        ->label('Codigo Postal'),
                    Forms\Components\Select::make('city_id')
                    ->label('Ciudad')
                    ->options(fn (Get $get): Collection => City::query()
                        ->where('state_id', $get ('state_id'))
                        ->pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                    Forms\Components\Select::make('state_id')
                        ->label('Provincia')
                        ->options(fn (Get $get): Collection => State::query()
                            ->where('country_id', $get ('country_id'))
                            ->pluck('name','id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set){
                            $set('city_id', null);
                        })
                        ->required(),
                    Forms\Components\Select::make('country_id')
                        ->relationship(name: 'Country', titleAttribute: 'name' )
                        ->label('Pais')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set){
                            $set('state_id', null);
                            $set('city_id', null);
                        })
                        ->required(),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
