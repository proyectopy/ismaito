<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CountryTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Paises Registrados', Country::query()->count()),
            Stat::make('Provincias Registradas', State::query()->count()),
            Stat::make('Ciudades Registradas', City::query()->count()),
        ];
    }
}
