<?php

namespace App\Models;

use Altwaireb\CountriesStatesCities\Models\Country as Model;

class Country extends Model
{
    protected static ?string $modelLabel = 'Pais';
    protected static ?string $pluralModelLabel = 'Paises';
}
