<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-s-globe-americas';

    protected static ?string $navigationGroup = 'Gestión del sistema';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pais';
    protected static ?string $pluralModelLabel = 'Paises';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('iso2')
                ->label('ISO2')
                    ->required(),
                Forms\Components\TextInput::make('iso3')
                    ->label('ISO3')
                    ->required(),
                Forms\Components\TextInput::make('numeric_code')
                    ->label('Codigo de Pais'),
                Forms\Components\TextInput::make('phonecode')

                    ->tel(),
                Forms\Components\TextInput::make('capital')
                    ->label('Capital'),
                Forms\Components\TextInput::make('currency')
                    ->label('Moneda'),
                Forms\Components\TextInput::make('currency_name')
                ->label('Nombre moneda'),
                Forms\Components\TextInput::make('currency_symbol')
                ->label('Simbolo moneda'),
                Forms\Components\TextInput::make('tld')
                ->label('TLD(Dominio)'),
                Forms\Components\TextInput::make('native')
                ->label('Nombre nativo'),
                Forms\Components\TextInput::make('region')
                ->label('Region'),
                Forms\Components\TextInput::make('subregion')
                ->label('Subregion'),
                Forms\Components\Textarea::make('timezones')
                ->label('Zona/s horaria/s')->columnSpanFull(),
                Forms\Components\Textarea::make('translations')
                ->label('Traducciones')->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')
                ->label('Latitud')->numeric(),
                Forms\Components\TextInput::make('longitude')
                ->label('Longitud')->numeric(),
                Forms\Components\TextInput::make('emoji')
                ->label('Emoji'),
                Forms\Components\TextInput::make('emojiU')
                ->label('Emoji Unicode'),
                Forms\Components\Toggle::make('flag')
                ->label('Bandera')->required(),
                Forms\Components\Toggle::make('is_active')
                ->label('Activo')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')->searchable(),
                Tables\Columns\TextColumn::make('iso2')
                    ->label('ISO2')->searchable(),
                Tables\Columns\TextColumn::make('iso3')
                    ->label('ISO3')->searchable(),
                Tables\Columns\TextColumn::make('numeric_code')
                    ->label('Cod Numérico')->searchable(),
                Tables\Columns\TextColumn::make('phonecode')
                    ->label('Cod Telefónico')->searchable(),
                Tables\Columns\TextColumn::make('capital')
                    ->label('Capital')->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->label('Moneda')->searchable(),
                Tables\Columns\TextColumn::make('currency_name')
                    ->label('Nombre moneda')->searchable(),
                Tables\Columns\TextColumn::make('currency_symbol')
                    ->label('Simbolo moneda')->searchable(),
                Tables\Columns\TextColumn::make('tld')
                    ->label('TLD(Dominio)')->searchable(),
                Tables\Columns\TextColumn::make('native')
                    ->label('Nombre nativo')->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Region')->searchable(),
                Tables\Columns\TextColumn::make('subregion')
                    ->label('Subregión')->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitud')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Longitud')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('emoji')
                    ->label('Emoji')->searchable(),
                Tables\Columns\TextColumn::make('emojiU')
                    ->label('Emoji Unicode')->searchable(),
                Tables\Columns\IconColumn::make('flag')
                    ->label('Bandera')->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()->sortable()
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

    public static function getWidgets(): array
    {
        return [
            CountryResource\Widgets\CountryOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
