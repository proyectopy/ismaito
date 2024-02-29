<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-s-globe-europe-africa';
    protected static ?string $navigationGroup = 'Gestión del sistema';
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Ciudad';
    protected static ?string $pluralModelLabel = 'Ciudades';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->label('Pais')->required(),
                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->label('Provincia')->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')
                    ->label('Latitud')->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->label('Longitud')->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activa')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Pais')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label('Provincia')->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ciudad')->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitud')->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                ->label('Longitud')->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                ->label('Activa')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Creada')->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizada')->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                ->label('Borrada')->dateTime()
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
